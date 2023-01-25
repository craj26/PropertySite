<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <?php  
    include 'header.php'; 
    
    require 'connection.php';
    $update = false;

    $obj = new DbCon();

    $conn = $obj->connect();

    $sql = "SELECT propertymaster.PropertyId, propertymaster.Name, propertymaster.Dimention, citymaster.CityName from propertymaster INNER JOIN citymaster on propertymaster.CityId = citymaster.CityId WHERE propertymaster.Sold = '0'";

    $result = $conn->query($sql);


    ?>
    

    <div class="body-container">
        <div class="banner">
            <h1>XYZ Builders Inc.</h1>
        </div>
        <div class="search">
            <form>
                <input type="text">
                <input type="submit">
            </form>
        </div>

        <div class="row">
            <h1>Latest Available Property</h1>
        </div>

        <div class="row">
        
        <?php 
            while ($row = $result->fetch_assoc())
            {
         ?>

            <div class="property">
                <a href=" <?php echo "/PropertySite/PropertyView?id=".$row["PropertyId"]; ?> "> <img src= <?php echo "images/Property/" . $row["PropertyId"] .  ".jpg" ?>  height="auto" width="200px"></a> 
                <a href=" <?php echo "/PropertySite/PropertyView?id=".$row["PropertyId"]; ?>"><h2><?php echo $row["Name"] ?></h2></a> 
                <h3><?php echo $row["CityName"] ?></h3>
                <h3><?php echo $row["Dimention"] . " Sq. Ft." ?></h3>
            </div>        


         <?php
        
            }
        
        ?>

           

           
        </div>

       

    </div>

    <?php include 'footer.php'; ?>

</body>
</html>