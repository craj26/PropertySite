<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="AdminContainer">
        
        <?php include 'AdminSidebar.php' ?>

        <div class="AdminMain">
            <h1>Registered Users</h1>
            <hr>
            <hr>
            <table class="UserList">
                <tr>
                    <th>User ID</th>
                    <th>Name </th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Occupation</th>
                    <th>City</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>abc</td>
                    <td>xxxxxxxxxx</td>
                    <td>abc, xyz</td>
                    <td>Business</td>
                    <td>Indore</td>
                </tr>
            </table>

        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>