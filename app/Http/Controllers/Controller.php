<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\User;
use Response;
use Storage;
use Carbon\Carbon;
use Thenextweb\PassGenerator;
use Thenextweb\Definitions\Generic;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createPass(Request $request)
    {

        return view('form.index');
    }

    public function submitDetails(Request $request)
    {
        $logo = '';
        $photo = '';
        $input = $request->all();
        $input['email'] = time() . '@email.com';
        $input['password'] = 'NIL';
        $input['pass_identifier'] = time() . '-' . bin2hex(random_bytes(9));

        $user = User::create($input);
        if ($user) {
            $userDetails = User::find($user->id);
            if ($request->hasFile('logo')) {
                //  Let's do everything here
                if ($request->file('logo')->isValid()) {
                    $image = $request->file('logo');
                    $folder = 'user-'.$userDetails->id;
                    $name = bin2hex(random_bytes(9)) . '_' . $request->logo->getClientOriginalName();
                    $file = $image->storeAs($folder, $name, 'passgenerator');
                    $logo = Storage::disk('passgenerator')->url($name);
                    $interventionImage = \Image::make($image)->stream("png", 100);
                    $file = $image->storeAs($folder, 'logo.png', 'passgenerator');
                    $update['logo'] = $name;
                }
            }

            if ($request->hasFile('photo')) {
                //  Let's do everything here
                if ($request->file('photo')->isValid()) {
                    $image = $request->file('photo');
                    $folder = 'user-'.$userDetails->id;
                    $name = bin2hex(random_bytes(9)) . '_' . $request->photo->getClientOriginalName();
                    $file = $image->storeAs($folder, $name, 'passgenerator');
                    $photo = Storage::disk('passgenerator')->url($name);
                    $interventionImage = \Image::make($image)->stream("png", 100);
                    $file = $image->storeAs($folder, 'thumbnail.png', 'passgenerator');
                    $update['photo'] = $name;
                }
            }

            //Update user details
            User::where(['id'=>$user->id])->update($update);

            $pass_identifier = $userDetails->pass_identifier;
            $serial = bin2hex(random_bytes(9));
            $pass = new PassGenerator($pass_identifier);
            $background = self::hexToRgb($userDetails->bcolor);
            $primary = self::hexToRgb($userDetails->pcolor);
            $label = self::hexToRgb($userDetails->lcolor);
            if (!$background) {
                $background['r'] = '255';
                $background['g'] = '255';
                $background['b'] = '255';
            }
            if (!$primary) {
                $primary['r'] = '255';
                $primary['g'] = '255';
                $primary['b'] = '255';
            }
            if (!$label) {
                $label['r'] = '255';
                $label['g'] = '255';
                $label['b'] = '255';
            }
            $pass_definition = [
                "description"       => "Dirk ter Horst",
                "formatVersion"     => 1,
                "organizationName"  => "Dirk ter Horst",
                "passTypeIdentifier" => "pass.com.wallet.card",
                "serialNumber"      => $serial,
                "teamIdentifier"    => "W6G2TUC225",
                "foregroundColor"   => "rgb(" . $primary['r'] . ", " . $primary['g'] . ", " . $primary['b'] . ")",
                "backgroundColor"   => "rgb(" . $background['r'] . ", " . $background['g'] . ", " . $background['b'] . ")",
                "labelColor"   => "rgb(" . $label['r'] . ", " . $label['g'] . ", " . $label['b'] . ")",
                "barcode" => [
                    "message"   => "encodedmessageonQR",
                    "format"    => "PKBarcodeFormatQR",
                    "altText"   => $userDetails->bar_code,
                    "messageEncoding" => "utf-8",
                ],
                "generic" => [
                    "headerFields" => [],
                    "primaryFields" => [
                        [
                            "key" => "name",
                            "label" => "Name",
                            "value" => $userDetails->name
                        ]
                    ],
                    "secondaryFields" => [
                        [
                            "key" => "company_name",
                            "label" => "Company name",
                            "value" => $userDetails->cname??'N/A'
                        ],
                        [
                            "key" => "role_company",
                            "label" => "Role in company",
                            "value" => $userDetails->role??'N/A'
                        ],
                        [
                            "key" => "department",
                            "label" => "Department",
                            "value" => $userDetails->department??'N/A'
                        ]
                    ],
                    "auxiliaryFields" => [],
                    "backFields" => [],
                    "locations" => []
                ],
            ];

            $pass->setPassDefinition($pass_definition);

            // Definitions can also be set from a JSON string
            // $pass->setPassDefinition(file_get_contents('/path/to/pass.json));

            // Add assets to the PKPass package
            //$pass->addAsset(base_path('storage/app/public/logo.jpeg'));
            $pass->addAsset(base_path('storage/app/public/'.$folder.'/logo.png'));
            $pass->addAsset(base_path('storage/app/public/'.$folder.'/thumbnail.png'));
            //$pass->addAsset(base_path('resources/logo.jpeg'));
            //$pass->addAsset(base_path('storage/app/public/'.$userDetails->logo));

            $pkpass = $pass->create();

            return response($pkpass, 200, [
                'Content-Transfer-Encoding' => 'binary',
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => 'attachment; filename="pass.pkpass"',
                'Content-length' => strlen($pkpass),
                'Content-Type' => PassGenerator::getPassMimeType(),
                'Pragma' => 'no-cache',
            ]);
        }
    }

    private static function hexToRgb($hex, $alpha = false)
    {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ($alpha) {
            $rgb['a'] = $alpha;
        }
        return $rgb;
    }
}
