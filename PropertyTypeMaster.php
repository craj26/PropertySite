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

    $sql = "select * from propertytypemaster";

    $result = $conn->query($sql);

    $id='';
    $propertytype='';

    $editResult='';
    $editRow='';

    if(isset($_GET["edit"]))
    {
        $update = true;
        $id = $_GET["edit"];

        $sql = "select * from propertytypemaster where PropertyTypeId='$id'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $propertytype = $editRow["PropertyType"];
        
    }

    if(isset($_POST["save"]))
    {
        $id = $_POST["txtPropertyTypeId"];
        $propertytype = $_POST["txtPropertyType"];


        $sql = "INSERT INTO propertytypemaster(PropertyType) VALUES ('$propertytype')";
        
        if($conn ->query($sql))
        {
            echo "<script> alert('Saved Successfully !!'); window.location.href='/propertysite/PropertyTypeMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }


    }

    if(isset($_POST["update"]))
    {
        $id = $_POST["txtPropertyTypeId"];
        $propertytype = $_POST["txtPropertyType"];

        $sql="UPDATE propertytypemaster SET PropertyType='$propertytype' WHERE PropertyTypeId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Updated Successfully !!'); window.location.href='/propertysite/PropertyTypeMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }
    }

    if(isset($_GET["del"]))
    {
        $id = $_GET["del"];

        $sql = "DELETE FROM propertytypemaster WHERE PropertyTypeId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Record Deleted !!'); window.location.href='/propertysite/PropertyTypeMaster' ;</script>";
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
            <h1>Property Type    Master</h1>
            <hr>
            <br>
            <form method="POST" action="PropertyTypeMaster.php">
                <div class="FormRow">
                    <label>Property ID:</label>
                    <input type="text" name="txtPropertyTypeId" value="<?php echo $id; ?>" readonly>
                </div>
                <div class="FormRow">
                    <label>City Name:</label><br>
                    <input type="text" name="txtPropertyType" value="<?php echo $propertytype; ?>">
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
                        Type Id
                    </th>
                    <th>
                        Property Type
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
                                echo $row["PropertyTypeId"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["PropertyType"];
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=/propertysite/PropertyTypeMaster?edit=" .$row["PropertyTypeId"].  ">Edit</a>";
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=javascript:del(" .$row["PropertyTypeId"]. ")>Delete</a>";
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
            window.location.href = '/propertysite/PropertyTypeMaster';
        }

        function del(id)
        {
            if(confirm("Are you sure want to delete ? "))
            {
                window.location.href = '/propertysite/PropertyTypeMaster?del='+id;
            }
        }
    </script>
</body>
</html>