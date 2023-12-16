<?php
session_start();
include('includes/config.php');
date_default_timezone_set('Asia/Kolkata');
include('includes/checklogin.php');
check_login();
$aid = $_SESSION['id'];

if (isset($_POST['update'])) {
    $prnno = $_POST['prnno'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $contactno = $_POST['contact'];
    $udate = date('d-m-Y h:i:s', time());
    $query = "UPDATE userRegistration SET prnno=?, firstName=?, middleName=?, lastName=?, gender=?, contactNo=?, updationDate=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssisi', $prnno, $fname, $mname, $lname, $gender, $contactno, $udate, $aid);
    $stmt->execute();
    echo "<script>alert('Profile updated successfully');</script>";
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
    <title>Profile Updation</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <?php
                $aid = $_SESSION['id'];
                $ret = "SELECT * FROM userregistration WHERE id=?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('i', $aid);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($row = $res->fetch_object()) {
                ?>
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="page-title"><?php echo $row->firstName; ?>'s Profile </h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Last Updation date: &nbsp; <?php echo $row->updationDate; ?>
                                        </div>
                                        <div class="panel-body">
                                            <form method="post" action="" name="registration" class="form-horizontal" onSubmit="return valid();">
											<div class="form-group">
                                                    <label class="col-sm-2 control-label">Profile Image: </label>
                                                    <div class="col-sm-8">
                                                        <?php if (!empty($row->profileImage)) { ?>
                                                            <img src="<?php echo $row->profileImage; ?>" alt="Profile Image" style="max-width: 200px; max-height: 200px;">
                                                        <?php } else { ?>
                                                            <p>No profile image found.</p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label"> Registration No : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="prnno" id="prnno" class="form-control" required="required" value="<?php echo $row->prnno; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">First Name : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $row->firstName; ?>" required="required">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Middle Name : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="mname" id="mname" class="form-control" value="<?php echo $row->middleName; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Last Name : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $row->lastName; ?>" required="required">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Gender : </label>
                                                    <div class="col-sm-8">
                                                        <select name="gender" class="form-control" required="required">
                                                            <option value="<?php echo $row->gender; ?>"><?php echo $row->gender; ?></option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="others">Others</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Contact No : </label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="contact" id="contact" class="form-control" maxlength="10" value="<?php echo $row->contactNo; ?>" required="required">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Email id: </label>
                                                    <div class="col-sm-8">
                                                        <input type="email" name="email" id="email" class="form-control" value="<?php echo $row->email; ?>" readonly>
                                                        <span id="user-availability-status" style="font-size:12px;"></span>
                                                    </div>
                                                </div>

                                                

                                                <div class="col-sm-6 col-sm-offset-4">
                                                    <input type="submit" name="update" Value="Update Profile" class="btn btn-primary">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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

</html>
