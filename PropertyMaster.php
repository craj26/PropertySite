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

    $sql = "select * from  propertymaster";

    $result = $conn->query($sql);

    $sql= "select * from cityMaster";
    $cityData=$conn->query($sql);

    $sql = "select * from propertytypemaster";
    $propertyTypeData = $conn->query($sql);



    $id='';
    $name='';
    $size='';
    $dimention='';
    $rate ='';
    $prize = '';
    $city ='';
    $propertyType='';
    $updateDate='';
    $status = '';
    $sold = '';

    $editResult='';
    $editRow='';

    if(isset($_GET["edit"]))
    {
        $update = true;
        $id = $_GET["edit"];

        $sql = "select * from PropertyMaster where PropertyId='$id'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $name=$editRow["Name"];
        $size=$editRow["Size"];
        $dimention=$editRow["Dimention"];
        $rate =$editRow["Rate"];
        $prize = $editRow["Prize"];
        $city =$editRow["CityId"];
        $propertyType=$editRow["PropertyType"];
        $status = $editRow["Status"];
        $sold = $editRow["Sold"];

        //echo "<script> alert('" .$sold. "')</script>";
        
    }

    if(isset($_POST["save"]))
    {
        date_default_timezone_set("Asia/Kolkata");
        //$id = $_POST["txtPropertyId"];
        $name=$_POST["txtName"];
        $size=$_POST["txtSize"];
        $dimention=$_POST["txtDimention"];
        $rate =$_POST["txtRate"];
        $prize = $_POST["txtPrize"];
        $city =$_POST["ddlCity"];
        $propertyType=$_POST["ddlPropertyType"];
        $status = $_POST["txtStatus"];
        $updateDate = date("d/m/yy h:i a");

        $sql = "select max(PropertyId) from propertymaster";
        $idNew = $conn ->query($sql);

        $idData = $idNew->fetch_array();

        $id = $idData[0] + 1 ;
        

        
        echo "inside update";

        $sql="INSERT INTO propertymaster(PropertyId, Name, Size, Dimention, Rate, Prize, CityId, PropertyType, UpdateDate, Status) VALUES ('$id','$name','$size','$dimention','$rate','$prize','$city','$propertyType','$updateDate','$status')";
        
        if($conn ->query($sql))
        {
                if ($_FILES["fileUpload"]["name"])
                {
                    
                    $targetDir = "images/Property/";  //terget  folder

                    $ext = pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION); //extension code
                    
                    if($ext != "jpg")
                    {
                        echo "<script>alert('use only jpg files !!');</script>";
                        die;
                    }

                    $targetLoc = $targetDir. $id . "." . $ext;

                    //echo $targetLoc;

                    try 
                    {
                        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetLoc);
                        clearstatcache();
                    } 
                    catch (\Throwable $th) 
                    {
                        echo "<script> alert('" .$th.  "') </script>" ;
                    }
                    
               

                }
            echo "<script> alert('Updated Successfully !!'); window.location.href='/PropertySite/PropertyMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }


    }

    if(isset($_POST["update"]))
    {
        
        
        date_default_timezone_set("Asia/Kolkata");
        $id = $_POST["txtPropertyId"];
        $name=$_POST["txtName"];
        $size=$_POST["txtSize"];
        $dimention=$_POST["txtDimention"];
        $rate =$_POST["txtRate"];
        $prize = $_POST["txtPrize"];
        $city =$_POST["ddlCity"];
        $propertyType=$_POST["ddlPropertyType"];
        $status = $_POST["txtStatus"];
        $updateDate = parse_str(date("d/m/yy h:i a"));
        
        //echo "inside update";

        $sql="UPDATE propertymaster SET Name='$name',Size='$size',Dimention='$dimention',Rate='$rate',Prize='$prize',CityId='$city',PropertyType='$propertyType',UpdateDate='$updateDate',Status='$status' WHERE PropertyId = '$id'";
        
        if($conn ->query($sql))
        {
                if ($_FILES["fileUpload"]["name"])
                {
                    
                    $targetDir = "images/Property/";  //terget  folder

                    $ext = pathinfo($_FILES["fileUpload"]["name"], PATHINFO_EXTENSION); //extension code
                    
                    if($ext != "jpg")
                    {
                        echo "<script>alert('use only jpg files !!');</script>";
                        die;
                    }

                    $targetLoc = $targetDir. $id . "." . $ext;

                    //echo $targetLoc;

                    try 
                    {
                        echo "hiii";
                        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $targetLoc);
                        clearstatcache();
                    } 
                    catch (\Throwable $th) 
                    {
                        echo "<script> alert('" .$th.  "') </script>" ;
                    }
                    
               

                }
            echo "<script> alert('Updated Successfully !!'); window.location.href='/PropertySite/PropertyMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }
    }

    if(isset($_GET["del"]))
    {
        $id = $_GET["del"];

        $sql = "delete from PropertyMaster where PropertyId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Record Deleted !!'); window.location.href='/propertysite/PropertyMaster';</script>";
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
            <h1>Property Master</h1>
            <hr>
            <br>
            <form method="POST" action="PropertyMaster.php" class="ProppertyFormMain" enctype="multipart/form-data">
                <div class="propertyForm">
                    <div class="FormRow">
                        <label>Property ID:</label><br>
                        <input type="text" name="txtPropertyId" value="<?php echo $id; ?>" readonly>
                    </div>
                    <div class="FormRow">
                        <label>Name:</label><br>
                        <input type="text" name="txtName" value="<?php echo $name; ?>">
                    </div>
                    <div class="FormRow">
                        <label>Size:</label><br>
                        <input type="text" name="txtSize" id="size" oninput="PrizeCalc()" value="<?php echo $size; ?> ">
                    </div>
                    <div class="FormRow">
                        <label>Dimention :</label><br>
                        <input type="text" name="txtDimention"  value="<?php echo $dimention; ?>">
                    </div>
                    <div class="FormRow">
                        <label>Rate:</label><br>
                        <input type="text" name="txtRate" id="rate" oninput="PrizeCalc()" value="<?php echo $rate;  ?>">
                    </div>
                    <div class="FormRow">
                        <label>Prize:</label><br>
                        <input type="text" name="txtPrize" id="prize" value="<?php echo $prize; ?>">
                    </div>
                    <div class="FormRow">
                        <label>Status:</label><br>
                        <input type="text" name="txtStatus" value="<?php echo $status; ?>">
                    </div>
                    <div class="FormRow">
                        <label>City :</label><br>
                        <select name="ddlCity" style="width:80%;padding:10px;">
                            <?php while($r = $cityData->fetch_assoc()) {  ?>
                                <option value="<?php echo $r["CityId"];?>" <?php echo ($r["CityId"] == $city )?'selected':''; ?> > <?php echo $r["CityName"];?></option>
                            <?php } ?> 

                        </select>
                    </div>
                    <div class="FormRow">
                        <label>Property Type :</label><br>
                        <select name="ddlPropertyType" style="width:80%;padding:10px;">
                            <?php while($p = $propertyTypeData->fetch_assoc()) {  ?>
                                <option value="<?php echo $p["PropertyTypeId"];?>" <?php echo ($p["PropertyTypeId"] == $propertyType )?'selected':''; ?> > <?php echo $p["PropertyType"];?></option>
                            <?php } ?> 

                        </select>
                    </div>

                    <div class="FormRow">
                        <label>Sold :</label><br>
                        <select name="ddlSold" style="width:80%;padding:10px;">
                            <option value="0" <?php echo ($sold == '0' )?'selected':''; ?> > Unsold </option>
                            <option value="1" <?php echo ($sold == '1' )?'selected':''; ?> > Sold  </option>                            
                        </select>
                    </div>
                    

                    <div class="FormRow" style="display: flex; justify-content: center;width: 50%;">
                    <?php if($update == false): ?>
                        <input type="submit" name="save" value="Save" class="btn" style="width: 100px;">
                    <?php else : ?>
                        <input type="submit" name="update" value="Update" class="btn" style="width: 100px;">
                    <?php endif ?>
                    <input type= "reset" value="Reset" onclick="refresh()"  class="btn" style="width: 100px;margin-left: 20px;">
                </div>
                </div>
                <div class="propertFrom2">
                    <img src="<?php echo "/Propertysite/images/Property/". $id.".jpg" ?> "    alt="Property Image" name="imgProperty" class="PropertyFormImg">
                    <br>

                    <input type="file" name="fileUpload" >   

                </div>
           
                
            </form>
            <br>
            <hr><hr>
            <br>
            <table class="CityTable">
                <tr>
                    <th>
                        Property Id.
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Size
                    </th>
                    <th>
                        Dimention
                    </th>
                    <th>
                        Rate
                    </th>
                    <th>
                        Prize
                    </th>
                    <th>
                        City
                    </th>
                    <th>
                        Property Type
                    </th>
                    <th>
                        Update Date
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Sold
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
                        echo "<tr>";
                            echo "<td>";
                                echo $row["PropertyId"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["Name"];
                            echo "</td>";

                            echo "<td>";
                                echo $row["Size"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["Dimention"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["Rate"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["Prize"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["CityId"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["PropertyType"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["UpdateDate"];
                            echo "</td>";
                            echo "<td>";
                                echo $row["Status"];
                            echo "</td>";
                            echo "<td>";
                                echo  ($row["Sold"] == 0)?'UnSold':'Sold';;
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=/PropertySite/PropertyMaster?edit=" .$row["PropertyId"].  ">Edit</a>";
                            echo "</td>";

                            echo "<td>";
                                echo "<a href=javascript:del(" .$row["PropertyId"]. ")>Delete</a>";
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
            window.location.href = '/propertysite/PropertyMaster';
        }

        function del(id)
        {
            if(confirm("Are you sure want to delete ? "))
            {
                window.location.href = '/propertysite/PropertyMaster?del='+id;
            }
        }

        function PrizeCalc()
        {
            var rate = parseInt(document.getElementById("rate").value) ;
            var size = parseInt(document.getElementById("size").value) ;
            var prize = document.getElementById("prize");

            prize.value = rate * size ;
        }
    </script>
</body>
</html>