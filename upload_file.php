<?php
session_start();
$host = "localhost";   // your database host
$user = "root";        // your database username
$pass = "";            // your database password
$db   = "mydb";  // your database name

$con = mysqli_connect($host, $user, $pass, $db);

if(!$con){
    die("Database connection failed: " . mysqli_connect_error());
}

require __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST['submit']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = 0;
        foreach($data as $row)
        {
            if($count > 0) // skip header row
            {
                $EmployeeID  = mysqli_real_escape_string($con, $row[0]);
                $Name        = mysqli_real_escape_string($con, $row[1]);
                $Department  = mysqli_real_escape_string($con, $row[2]);
                $Designation = mysqli_real_escape_string($con, $row[3]);
                $JoiningDate = date('Y-m-d', strtotime($row[4])); 
                $Salary      = mysqli_real_escape_string($con, $row[5]);
                $Email       = mysqli_real_escape_string($con, $row[6]);

                $employeeQuery = "INSERT INTO Employees 
                    (EmployeeID, Name, Department, Designation, JoiningDate, Salary, Email) 
                    VALUES 
                    ('$EmployeeID','$Name','$Department','$Designation','$JoiningDate','$Salary','$Email')";

                mysqli_query($con, $employeeQuery);
                $msg = true;
            }
            else
            {
                $count = 1; 
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Employees Imported Successfully";
        }
        else
        {
            $_SESSION['message'] = "No Data Imported";
        }

        header('Location: upload_file.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Invalid File Format";
        header('Location: upload_file.php');
        exit(0);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <link rel="stylesheet" href="upload_style.css">
</head>
<body>
    <?php if(isset($_SESSION['message'])): ?>
        <p style="color: green; font-weight: bold;">
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']); 
            ?>
        </p>
    <?php endif; ?>

    <form action="upload_file.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="upload">Choose a file location</label>
            <input type="file" name="import_file" required>
        </div>
        <div>
            <button type="submit" name="submit">Upload</button>
        </div>
    </form>
</body>
</html>
