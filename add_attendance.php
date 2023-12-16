<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['attendance'])) {
    $attendance = $_POST['attendance'];
    
    // Connect to the database
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $dbname = 'sanjivani';
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare the SQL statement for inserting attendance data
    $stmt = $conn->prepare("INSERT INTO attendance (prnno, name, year, contactno, email, attendance) VALUES (?, ?,?,?,?,?)");
    $stmt->bind_param("ssiisi", $prnno, $attend);
    
    // Loop through the attendance data and insert into the database
    foreach ($attendance as $key => $attend) {
        $prnno = $_POST['prnno'][$key]; // Assuming you have an input field for PRN No.
        $stmt->execute();
    }
    
    $stmt->close();
    $conn->close();
    
    echo "<script>alert('Attendance submitted successfully');</script>";
}
?>
