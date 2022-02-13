<form class="form-horizontal" method="POST" enctype="multipart/form-data" action="/create-pass">

  {{ csrf_field() }}

  <label for="name">Your name</label>
  <input type="text" id="name" name="name" autocomplete="off" required placeholder="Your name">

  <label for="logo">Upload logo</label>
  <input type="file" id="logo" name="logo"  accept="image/png, image/jpeg, image/jpg" required placeholder="">

  <label for="photo">Upload profile photo</label>
  <input type="file" id="photo" name="photo" accept="image/png, image/jpeg, image/jpg" required placeholder="">

  <label for="cname">Company name</label>
  <input type="text" id="cname" name="cname" autocomplete="off" placeholder="Company name">

  <label for="role">Role in company</label>
  <input type="text" id="role" name="role" autocomplete="off" placeholder="Role in company">

  <label for="department">Department</label>
  <input type="text" id="department" name="department" autocomplete="off" placeholder="Department">

  <label for="bar_code">Enter URL for QR code</label>
  <input type="text" id="bar_code" name="bar_code" autocomplete="off" required placeholder="Enter URL for QR code">

  <label for="bcolor">Enter hex for background color</label>
  <input type="color" id="bcolor" name="bcolor" value="#ffffff" required placeholder="Background Color">

  <label for="pcolor">Enter hex for primary text color</label>
  <input type="color" id="pcolor" name="pcolor" value="#000000" required placeholder="Primary Text Color">

  <label for="lcolor">Enter hex for label text color</label>
  <input type="color" id="lcolor" name="lcolor" value="#000000" required placeholder="Label Text Color">

  <input type="submit" value="Add To Wallet">

</form>