<?php
session_start();
include('includes/config.php');

if (isset($_POST['submit'])) {
  $prnno = $_POST['prnno'];
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $gender = $_POST['gender'];
  $contactno = $_POST['contact'];
  $emailid = $_POST['email'];
  $password = $_POST['password'];

  $targetDir = "profile_images/";
  $targetFile = $targetDir . basename($_FILES["profileImage"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    echo "<script>alert('File is not an image.');</script>";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($targetFile)) {
    echo "<script>alert('Sorry, file already exists.');</script>";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["profileImage"]["size"] > 5000000) {
    echo "<script>alert('Sorry, your file is too large.');</script>";
    $uploadOk = 0;
  }

  // Allow certain file formats
  $allowedExtensions = array("jpg", "jpeg", "png", "gif");
  if (!in_array($imageFileType, $allowedExtensions)) {
    echo "<script>alert('Sorry, only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
    $uploadOk = 0;
  }

  // If file upload checks pass, move the file to the target directory
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
      $profileImagePath = $targetFile;
    } else {
      echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
      $profileImagePath = null;
    }
  } else {
    $profileImagePath = null;
  }

  $query = "INSERT INTO userRegistration(prnno, firstName, middleName, lastName, gender, contactNo, email, password, profileImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('sssssisss', $prnno, $fname, $mname, $lname, $gender, $contactno, $emailid, $password, $profileImagePath);

  if ($stmt->execute()) {
    echo "<script>alert('Student successfully registered.');</script>";
  } else {
    echo "<script>alert('Error: Student registration failed.');</script>";
  }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>User Registration</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
function valid()
{
if(document.registration.password.value!= document.registration.cpassword.value)
{
alert("Password and Re-Type Password Field do not match  !!");
document.registration.cpassword.focus();
return false;
}
return true;
}
</script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Student Registration </h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">Fill all Info</div>
									<div class="panel-body">
			<form method="post" action="" name="registration" class="form-horizontal" onSubmit="return valid();"  enctype="multipart/form-data">
											
										
			<div class="form-group">
  <label class="col-sm-2 control-label">Profile Image: </label>
  <div class="col-sm-8">
    <input type="file" name="profileImage" id="profileImage" class="form-control">
  </div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label"> PRN No : </label>
<div class="col-sm-8">
<input type="text" name="prnno" id="prnno"  class="form-control" required="required" >
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">First Name : </label>
<div class="col-sm-8">
<input type="text" name="fname" id="fname"  class="form-control" required="required" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Middle Name : </label>
<div class="col-sm-8">
<input type="text" name="mname" id="mname"  class="form-control">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Last Name : </label>
<div class="col-sm-8">
<input type="text" name="lname" id="lname"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Gender : </label>
<div class="col-sm-8">
<select name="gender" class="form-control" required="required">
<option value="">Select Gender</option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="others">Others</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Contact No : </label>
<div class="col-sm-8">
<input type="text" name="contact" id="contact"  class="form-control" required="required">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Email id: </label>
<div class="col-sm-8">
<input type="email" name="email" id="email"  class="form-control" onBlur="checkAvailability()" required="required">
<span id="user-availability-status" style="font-size:12px;"></span>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Password: </label>
<div class="col-sm-8">
<input type="password" name="password" id="password"  class="form-control" required="required">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Confirm Password : </label>
<div class="col-sm-8">
<input type="password" name="cpassword" id="cpassword"  class="form-control" required="required">
</div>
</div>
						



<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Cancel</button>
<input type="submit" name="submit" Value="Register" class="btn btn-primary">
</div>
</form>

									</div>
									</div>
								</div>
							</div>
						</div>
							</div>
						</div>
					</div>
				</div> 	
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
	<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function ()
{
event.preventDefault();
alert('error');
}
});
}
</script>

</html>