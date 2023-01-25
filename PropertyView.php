<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Property</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
        include 'header.php'; 

        require 'connection.php';
        $obj = new DbCon();
        $conn = $obj->connect();

        $id='';
        $data = '';
        $cityname='';

        date_default_timezone_set("Asia/Kolkata");
        $date = date("d/m/yy");

        
        $id = $_GET["id"];

        define('$property', $id);
        
        $sql = "select * from PropertyMaster where PropertyId='$id'";
        $result = $conn->query($sql);

        $data = $result->fetch_assoc();

        $sql="select CityName from CityMaster where CityId='" .$data["CityId"] ."'";
        $result = $conn->query($sql);

        $row = $result->fetch_array();

        $cityname = $row[0];

        echo $id;

        if(isset($_GET["Submit"]))
        {      
                $proprtyid = $data["PropertyId"] ; 
                echo "<script> alert('" .$proprtyid. "');</script>" ;
                $userId = $_SESSION["user"]["UserId"];
               
                $sql = "INSERT INTO booking(UserId, Date, Status, PropertyId) VALUES ('$userId','$date','Available','$proprtyid')";
                echo $sql;

                // if ($conn->query($sql))
                // {
                //     echo "<script>alert ('Thank You for your booking. Our executive will contact you for further details !!'); window.location.href = '/propertysite/'; </script>";
                // }
                // else
                // {
                //     echo "error";
                // }

           
        }


    ?>    

    <div class="body-container">
        <div class="PropertyHeading">
            <h1><center><?php echo $data["Name"] ?></center></h1>
            <hr><hr>
        </div>
        <div class="PropertyViewMain">
            <div class="PropertyImage">
                <img src="<?php echo "images/Property/".$id.".jpg"?>" alt="Property Image">    
            </div>

            <div class="PropertyDetails">
                <h2>Size:  <?php echo $data["Size"] ?> Sq.Ft</h2>
                <h2>Dimention : <?php echo $data["Dimention"] ?></h2>
                <h2>Rate : <?php echo $data["Rate"] ?> Per Sq. Ft</h2>
                <h2>Prize:  Rs. <?php echo $data["Prize"] ?></h2>
                <h2>Location: <?php echo $cityname ?> </h2>
                <!-- <h3>Details :</h3> -->

                <form method="GET" action="PropertyView.php">
                    <input type="submit" name="Submit" value="Book Now">
                </form>
            </div>
            
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
</body>
</html>