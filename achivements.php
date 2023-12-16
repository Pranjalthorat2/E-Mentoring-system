<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// code for registration
if(isset($_POST['submit']))
{
  $achiv_name=$_POST['achiv_name'];
  $achiv_date=date('Y-m-d', strtotime($_POST['achiv_date']));
  $achiv_disc=$_POST['achiv_disc'];
  $cour_name=$_POST['cour_name'];
  $cour_date=date('Y-m-d', strtotime($_POST['cour_date']));
  $cour_disc=$_POST['cour_disc'];
  $inter_name=$_POST['inter_name'];
  $inter_date=date('Y-m-d', strtotime($_POST['inter_date']));
  $inter_disc=$_POST['inter_disc'];

  $achiv_file = '';
  if (isset($_FILES['achiv_file']) && $_FILES['achiv_file']['error'] === UPLOAD_ERR_OK) {
    $achiv_file = rand(1000, 10000) . '_' . $_FILES['achiv_file']['name'];
    move_uploaded_file($_FILES['achiv_file']['tmp_name'], 'uploads/' . $achiv_file);
  }

  $query="INSERT INTO achivements(achiv_name,achiv_date,achiv_disc,cour_name,cour_date,cour_disc,inter_name,inter_date,inter_disc,achiv_file) VALUES(?,?,?,?,?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  $rc=$stmt->bind_param('ssssssssss',$achiv_name,$achiv_date,$achiv_disc,$cour_name,$cour_date,$cour_disc,$inter_name,$inter_date,$inter_disc,$achiv_file);
  $stmt->execute();

  if($stmt) {
    echo"<script>alert('Submission Taken Successfully');</script>";
  } else {
    echo"<script>alert('Submission Failed');</script>";
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
	<title>Student Registration</title>
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
<script>
function getSeater(val) {
$.ajax({
type: "POST",
url: "get_seater.php",
data:'roomid='+val,
success: function(data){
//alert(data);
$('#seater').val(data);
}
});

$.ajax({
type: "POST",
url: "get_seater.php",
data:'rid='+val,
success: function(data){
//alert(data);
$('#fpm').val(data);
}
});
}
</script>

</head>
<style>
	body
	{
		margin-top: 30px;
	}
	</style>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
		<?php include('includes/sidebar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Achivements </h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading">Fill all Info</div>
									<div class="panel-body">
										<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
							<?php
$uid=$_SESSION['login'];
							 $stmt=$mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? ");
				$stmt->bind_param('s',$uid);
				$stmt->execute();
				$stmt -> bind_result($email);
				$rs=$stmt->fetch();
				$stmt->close();
				if($rs)
				{ ?>
			<h3 style="color: red" align="left">Submission Already Taken</h3>
				<?php }
				else{
							echo "";
							}			
							?>			
<div class="form-group">
<label class="col-sm-4 control-label"><h4 style="color: green" align="left">Achivements Info </h4> </label>
</div>

	

<div class="form-group">
<label class="col-sm-2 control-label">Name of Achivements :</label>
<div class="col-sm-8">
<input type="text" name="achiv_name" id="achiv_name"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Date :</label>
<div class="col-sm-8">
<input type="date" name="achiv_date" id="achive_date"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Discription : </label>
<div class="col-sm-8">
<textarea  rows="5" name="achiv_disc"  id="achiv_disc" class="form-control" ></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Upload Certificates : </label>
<input type="file" name="achiv_file" accept=".pdf,.jpg,.png" multiple>
<script lang="javascript">
function submitForm() {
  var form = document.querySelector('form');
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'submit.php', true);
  xhr.onload = function() {
    // handle response from server
  };
  xhr.send(formData);
}

</script>
<div class="col-sm-8">
</div>
</div><hr>



<div class="form-group">
<label class="col-sm-2 control-label"><h4 style="color: green" align="left">Courses Info </h4> </label>
</div>
	
	

<div class="form-group">
<label class="col-sm-2 control-label">Name of Courses :</label>
<div class="col-sm-8">
<input type="text" name="cour_name" id="cour_name"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Complition Date :</label>
<div class="col-sm-8">
<input type="date" name="cour_date" id="cour_date"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Discription : </label>
<div class="col-sm-8">
<textarea  rows="5" name="cour_disc"  id="cour_disc" class="form-control" ></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Upload Certificates : </label>
<input type="file" name="cour_file" accept=".pdf,.jpg,.png" multiple>
<script lang="javascript">
function submitForm() {
  var form = document.querySelector('form');
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'submit.php', true);
  xhr.onload = function() {
    // handle response from server
  };
  xhr.send(formData);
}

</script>
<div class="col-sm-8">
</div>
</div><hr>


<div class="form-group">
<label class="col-sm-3 control-label"><h4 style="color: green" align="left">Internship Info </h4> </label>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Name of Internship :</label>
<div class="col-sm-8">
<input type="text" name="inter_name" id="inter_name"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Complition Date :</label>
<div class="col-sm-8">
<input type="date" name="inter_date" id="inter_date"  class="form-control" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Discription : </label>
<div class="col-sm-8">
<textarea  rows="5" name="inter_disc"  id="inter_disc" class="form-control" ></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Upload Certificates : </label>
<input type="file" name="inter_file" accept=".pdf,.jpg,.png" multiple>
<script lang="javascript">
function submitForm() {
  var form = document.querySelector('form');
  var formData = new FormData(form);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'submit.php', true);
  xhr.onload = function() {
    // handle response from server
  };
  xhr.send(formData);
}

</script>
<div class="col-sm-8">
</div>
</div>


<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Cancel</button>
<input type="submit" name="submit" Value="Submit" class="btn btn-primary" onclick="submitForm()">
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
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
	<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'roomno='+$("#room").val(),
type: "POST",
success:function(data){
$("#room-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


<script type="text/javascript">

$(document).ready(function() {
	$('#duration').keyup(function(){
		var fetch_dbid = $(this).val();
		$.ajax({
		type:'POST',
		url :"ins-amt.php?action=userid",
		data :{userinfo:fetch_dbid},
		success:function(data){
	    $('.result').val(data);
		}
		});
		

})});
</script>

</html>