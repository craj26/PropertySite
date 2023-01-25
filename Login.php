<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php 
        include 'header.php'; 
        require 'connection.php';
    
        $obj = new DbCon();
        $conn = $obj->connect();  

        

        $userName = '';
        $pwd = '';
        $result='';

        if(isset($_POST["submit"]))
        {
            $userName = $_POST["txtUserId"];
            $pwd = $_POST["txtPwd"];

            $sql = "select * from user where UserName='$userName' and Password ='$pwd'";
           
            $result = $conn->query($sql);

            if($result->num_rows==0)
            {
                echo "<script> alert('Invalid User Name or Password !!'); </script>";
            }
            else
            {
                session_start();

                $_SESSION["user"] = $result->fetch_assoc();

                echo "<script> alert('" . $_SESSION["user"]["MobileNo"] . "') </script>";

                echo "<script>window.location.href = '/propertysite/';</script>";
            }

        }

    ?>

     <div class="body-container">
         <div class="LoginMain">
             <h1>Administrator Login</h1>

             <form method="POST" action="Login.php">
                <div class="LoginRow">
                    <p>Login Id:</p>
                    <p><input type="text" name="txtUserId" placeholder="Enter Your User Id" ></p>
                </div>
                <div class="LoginRow">
                    <p>Password:</p>
                    <p><input type="password" name="txtPwd" placeholder="Enter Your Password"> </p>
                </div>    
                <div class="LoginRow">
                    <center>
                    <input type="submit" value="Submit" name="submit">
                    <input type="reset" value="Reset">
                </center>
                </div>

             </form>

         </div>
     </div>

    
</body>
</html>