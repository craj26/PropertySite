<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php 
    
    include 'header.php'; 
    
    require 'connection.php';
    $update = false;

    $obj = new DbCon();

    $conn = $obj->connect();

    $sql = "SELECT booking.BookingId, user.Name, user.MobileNo, user.Occupation, booking.PropertyId, propertymaster.Name, booking.Status, citymaster.CityName from booking INNER JOIN user on booking.UserId = user.UserId INNER JOIN propertymaster on booking.PropertyId = propertymaster.PropertyId INNER JOIN citymaster on propertymaster.CityId = citymaster.CityId";
    //echo $sql;
    $result = $conn->query($sql);

    $Status = '';
    $id='';


    if(isset($_GET["edit"]))
    {
        $id = $_GET["edit"];

        $sql = "select * from Booking where BookingId='$id'";
        $editResult = $conn->query($sql);

        $editRow = $editResult->fetch_assoc();

        $Status = $editRow["Status"];
       
    }

    if(isset($_POST["Update"]))
    {
        date_default_timezone_set("Asia/Kolkata");
        $id = $_POST["txtBookingId"];
        $Status = $_POST["txtStatus"];
        $date = parse_str(date("d/m/yy h:i a"));

        $sql="UPDATE booking SET Date='$date',Status='$Status' WHERE BookingId='$id'";

        if($conn ->query($sql))
        {
            echo "<script> alert('Updated Successfully !!'); window.location.href='/propertysite/BookingMaster' ;</script>";
        }
        else
        {
            echo "<script> alert('Error saving Data !!') </script>";
        }
    }
    
    ?>

    <div class="AdminContainer">
        
        <?php include 'AdminSidebar.php'; ?>

        <div class="AdminMain">
            <h1>Booking Master</h1>
            <hr>
            <br>
            <form method="POST" action="BookingMaster.php">
                <div class="FormRow">
                    <label>Booking ID:</label><br>
                    <input  type="text" name="txtBookingId" value="<?php echo $id; ?>" readonly>
                </div>
                
                <div class="FormRow">
                    <label>Status:</label><br>
                    <input type="text" name="txtStatus" value="<?php echo $Status; ?>" >
                </div>
                <div class="FormRow" style="display: flex; justify-content: center;width: 50%;">
                    <input type="submit" value="Update" name="Update" class="btn" style="width: 100px;">
                    <input type= "reset" value="Reset" onclick="refresh()" class="btn" style="width: 100px;margin-left: 20px;">
                </div>
            </form>
            <br>
            <hr><hr>
            <br>
            <table class="CityTable">
                <tr>
                    <th>
                        Booking Id.
                    </th>
                    <th>
                        User Name
                    </th>
                    <th>
                        User Mobile
                    </th>
                    <th>
                        Occupation
                    </th>
                    <th>
                        Property ID
                    </th>
                    <th>
                        Property Name
                    </th>
                    <th>
                        Property City
                    </th>
                    <th>
                        Status                            
                    </th> 
                    <th>
                        Update
                    </th>
                </tr>
                <?php 
                
                    while ($row = $result->fetch_array())
                    {
                        echo "<tr>";
                            echo "<td>";
                                echo $row[0];
                            echo "</td>";

                            echo "<td>";
                                echo $row[1];
                            echo "</td>";

                            echo "<td>";
                                echo $row[2];
                            echo "</td>";

                            echo "<td>";
                                echo $row[3];
                            echo "</td>";

                            echo "<td>";
                                echo "<a href='/PropertySite/propertyView?id=$row[4]' target='_blank'>".$row[4]."</a>";
                            echo "</td>";

                            echo "<td>";
                                echo $row[5];
                            echo "</td>";

                            echo "<td>";
                                echo $row[7];
                            echo "</td>";

                            echo "<td>";
                                echo $row[6];
                            echo "</td>";

                            echo "<td>";
                            echo "<a href=/propertysite/BookingMaster?edit=" .$row[4].  ">Edit</a>";
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
            window.location.href = '/propertysite/BookingMaster';
        }
        
    </script>
</body>
</html>