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
    $update = false;

    $obj = new DbCon();

    $conn = $obj->connect();

    $sql = "select * from CityMaster";

    $result = $conn->query($sql);

    $id='';
    $city ='';
    $state ='';

    $editResult='';
    $editRow='';

    if(isset($_GET["edit"]))
    {
        $update = true;
        $id = $_GET["edit"];

        $sql = "select * from CityMaster where CityId='$id'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $city = $editRow["CityName"];
        $state = $editRow["State"];
        
    }

    if(isset($_POST["save"]))
    {
        $id = $_POST["txtCityId"];
        $city = $_POST["txtCity"];
        $state = $_POST["txtState"];

        $sql = "INSERT INTO citymaster(CityName, State) VALUES ('$city', '$state')";
        
        if($conn ->query($sql))
        {
            echo "<script> alert('Saved Successfully !!'); window.location.href='/propertysite/CityMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }


    }

    if(isset($_POST["update"]))
    {
        $id = $_POST["txtCityId"];
        $city = $_POST["txtCity"];
        $state = $_POST["txtState"];

        $sql="UPDATE citymaster SET CityName='$city',State='$state' WHERE CityId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Updated Successfully !!'); window.location.href='/propertysite/CityMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }
    }

    if(isset($_GET["del"]))
    {
        $id = $_GET["del"];

        $sql = "delete from CityMaster where CityId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Record Deleted !!'); window.location.href='/propertysite/CityMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error deleting Data !!') </script>";
        }

    }

?>
    <div class="AdminContainer">
       <?php include 'AdminSidebar.php'; ?>
        <div class="AdminMain">
            <h1>City Master</h1>
            <hr>
            <br>
            <form method="POST" action="CityMaster.php">
                <div class="FormRow">
                    <label>City ID:</label>
                    <input type="text" name="txtCityId" value="<?php echo $id; ?>" readonly>
                </div>
                <div class="FormRow">
                    <label>City Name:</label><br>
                    <input type="text" name="txtCity" value="<?php echo $city; ?>">
                </div>
                <div class="FormRow">
                    <label>State Name:</label><br>
                    <input type="text" name="txtState" value="<?php echo $state; ?>">
                </div>
                <div class="FormRow" style="display: flex; justify-content: center;width: 50%;">
                    <?php if($update == false): ?>
                        <input type="submit" name="save" value="Save" class="btn" style="width: 100px;">
                    <?php else : ?>
                        <input type="submit" name="update" value="Update" class="btn" style="width: 100px;">
                    <?php endif ?>
                    <input type= "reset" value="Reset" onclick="refresh()"  class="btn" style="width: 100px;margin-left: 20px;">
                </div>
            </form>
            <br>
            <hr><hr>
            <br>
            <table class="CityTable">
                <tr>
                    <th>
                        City Id.
                    </th>
                    <th>
                        City Name
                    </th>
                    <th>
                        State Name
                    </th>
                    <th>
                        Edit
                    </th>
                    <th>Delete</th>
                </tr>

                <?php 
                    while ($row = $result->fetch_assoc())
                    {
                        echo "<tr>";
                            echo "<td>";
                                echo $row["CityId"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["CityName"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["State"];
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=/propertysite/citymaster?edit=" .$row["CityId"].  ">Edit</a>";
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=javascript:del(" .$row["CityId"]. ")>Delete</a>";
                            echo "</td>";

                        echo "</tr>";
                    }
                
                ?>
                
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script type="text/Javascript">
        function refresh()
        {
            window.location.href = '/propertysite/CityMaster';
        }

        function del(id)
        {
            if(confirm("Are you sure want to delete ? "))
            {
                window.location.href = '/propertysite/CityMaster?del='+id;
            }
        }
    </script>
</body>
</html>