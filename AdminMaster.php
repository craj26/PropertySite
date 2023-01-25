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

    $sql = "select * from admin";

    $result = $conn->query($sql);

    $sql ="select * from CityMaster";
    $cityData = $conn->query($sql);

    $id='';
    $city ='';
    $name='';
    $designation='';
    $userName ='';
    $pwd = '';
    $cityName='';

    $editResult='';
    $editRow='';

    if(isset($_GET["edit"]))
    {
        $update = true;
        $id = $_GET["edit"];

        $sql = "select * from admin where AdminId='$id'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $name = $editRow["Name"];
        $designation = $editRow["Designation"];
        $city = $editRow["CityId"];
        $userName = $editRow["UserName"];
        $pwd = $editRow["Password"];
        
        $sql = "select CityName from CityMaster where CityId='$city'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $cityName = $editRow["CityName"];
        
    }

    if(isset($_POST["save"]))
    {
        
        $name=$_POST["txtName"];
        $designation= $_POST["txtDesignation"];
        $city = $_POST["ddlCity"];
        $userName=$_POST["txtUserName"];
        $pwd=$_POST["txtPassword"];

        $sql = "INSERT INTO admin(Name, Designation, CityId, Password, UserName) VALUES ('$name','$designation','$city','$pwd','$userName')";
        
        if($conn ->query($sql))
        {
            echo "<script> alert('Saved Successfully !!'); window.location.href='/propertysite/AdminMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }


    }

    if(isset($_POST["update"]))
    {
        $id = $_POST["txtAdminId"];
        $name=$_POST["txtName"];
        $designation= $_POST["txtDesignation"];
        $city = $_POST["ddlCity"];
        $userName=$_POST["txtUserName"];
        $pwd=$_POST["txtPassword"];

        $sql="UPDATE admin SET Name='$name',Designation='$designation',CityId='$city',Password='$pwd',UserName='$userName' WHERE AdminId = '$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Updated Successfully !!'); window.location.href='/propertysite/AdminMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }
    }

    if(isset($_GET["del"]))
    {
        $id = $_GET["del"];

        $sql = "delete from Admin where AdminId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Record Deleted !!'); window.location.href='/propertysite/AdminMaster' ;</script>";
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
            <h1>Admin User Master</h1>
            <hr>
            <br>
            <form method="POST" action="AdminMaster.php">
                <div class="FormRow">
                    <label>Admin ID:</label><br>
                    <input type="text" name="txtAdminId" value="<?php echo $id; ?>" readonly>
                </div>
                <div class="FormRow">
                    <label>Name:</label><br>
                    <input type="text" name="txtName" value="<?php echo $name; ?>">
                </div>
                <div class="FormRow">
                    <label>Designation:</label><br>
                    <input type="text" name="txtDesignation" value="<?php echo $designation; ?>">
                </div>

                <div class="FormRow">
                    <label>City :</label><br>
                    <select name="ddlCity" style="width:50%;padding:10px;">
                        <?php while($r = $cityData->fetch_assoc()) {  ?>
                            <option value="<?php echo $r["CityId"];?>" <?php echo ($r["CityId"] == $city )?'selected':''; ?> > <?php echo $r["CityName"];?></option>
                        <?php } ?>

                    </select>
                </div>

                <div class="FormRow">
                    <label>User Name :</label><br>
                    <input type="text" name="txtUserName" value="<?php echo $userName; ?>">
                </div>

                <div class="FormRow">
                    <label>Password :</label><br>
                    <input type="Password" name="txtPassword" value="<?php echo $pwd; ?>">
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
                        Admin Id.
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Designation
                    </th>
                    <th>
                        City
                    </th>
                    <th>
                        Username
                    </th>
                    <th>
                        Edit
                    </th>
                    <th>
                        Delete
                    </th>
                </tr>

                <?php 
                    while ($row = $result->fetch_assoc())
                    {
                        $sql = "select CityName from CityMaster where CityId='" .$row["CityId"]. "'";
                        $editResult = $conn->query($sql);
                        $editRow = $editResult->fetch_assoc();

                        echo "<tr>";
                            echo "<td>";
                                echo $row["AdminId"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["Name"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["Designation"];
                            echo "</td>";

                            echo "<td>";
                                echo $editRow["CityName"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["UserName"];
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=/propertysite/adminmaster?edit=" .$row["AdminId"].  ">Edit</a>";
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=javascript:del(" .$row["AdminId"]. ")>Delete</a>";
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
            window.location.href = '/propertysite/AdminMaster';
        }

        function del(id)
        {
            if(confirm("Are you sure want to delete ? "))
            {
                window.location.href = '/propertysite/AdminMaster?del='+id;
            }
        }
    </script>
</body>
</html>