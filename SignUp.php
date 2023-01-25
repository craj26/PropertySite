<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php 
    include 'header.php'; 
    require 'connection.php';

    $obj = new DbCon();
    $conn = $obj->connect();   
    
    

    if(isset($_POST["submit"]))
    {
        $name = $_POST["UsrName"];
        $mobile = $_POST["UsrMobile"];
        $address = $_POST["UsrAddress"];
        $occupation = $_POST["UsrOccupation"];
        $city = $_POST["UsrCity"];
        $username = $_POST["UsrUserName"];
        $pwd = $_POST["UsrPwd"];

        $sql = "select * from user where UserName = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0)
        {
            echo "<script> alert('User Name already exists !!'); </script>";
            
        }
        else
        {
            $sql = "INSERT INTO user( Name, MobileNo, Address, Occupation, City, UserName, Password) VALUES ('$name','$mobile','$address','$occupation','$city','$username','$pwd')";

            if($conn->query($sql))
            {
                echo "<script> alert('User Registration successfull !!'); window.location.href = '/propertysite/'; </script>";
            }
        }

    }


?>  

    <div class="body-container">
        <h1>User Registration</h1>
        <hr>
        <hr>

        <form method="POST" action="SignUp.php">
            <div class="FormRow">
                Name: <br>
                <input type="text" name="UsrName" placeholder="Enter Your Name">
            </div>
            <div class="FormRow">
                Mobile No: <br>
                <input type="text" name="UsrMobile" placeholder="Enter Your Mobile No">
            </div>
            <div class="FormRow">
                Address: <br>
                <textarea name="UsrAddress"  placeholder="Enter Your Address"></textarea>
            </div>
            <div class="FormRow">
                Occupation: <br>
                <input type="text" name="UsrOccupation" placeholder="Enter Your Occupation">
            </div>
            <div class="FormRow">
                City: <br>
                <input type="text" name="UsrCity" placeholder="Enter Your City">

                
            </div>
            <div class="FormRow">
                User Name : <br>
                <input type="text" name="UsrUserName" placeholder="Enter Your User Name">
            </div>
            <div class="FormRow">
                Password: <br>
                <input type="password" name="UsrPwd" placeholder="Enter Your Password">
            </div>
            <div class="FormRow" style="display: flex; width: 50%;justify-content: center;">
                <input type="submit" name="submit" value="Submit" style="width: 150px; margin-left: 20px;">
                <input type="reset" value = "Reset" style="width: 150px; margin-left: 20px;">
            </div>

        </form>
        <br>
    </div>


    <?php include 'footer.php'; ?>
</body>
</html>