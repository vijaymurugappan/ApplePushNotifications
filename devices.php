<html>
<head>
<title> ADD CLASS </title>
</head>
<body>
<?php
    $servername = "courses";
    $username = "z1807314";
    $password = "1994May07";
    $dbname = "z1807314";
    
    //Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    $action = $_SERVER["PHP_SELF"];
    //Creating Form for Method Post
    echo '<form name="devices.php" action=';
    echo $action;
    echo ' method="POST">';
    //storing device ID
    echo "<br>DEVICE ID";
    echo '<br><input type="text" name="deviceid">';
    //Submit button
    echo '<br><input type = "submit" value = "ADD ID"><br><br>';
    echo '</form>';
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Assigning values to table
        $deviceID = $_POST["deviceid"];
        if('$deviceID')
        {
            
            $sql1 = "insert into devices(deviceID)values('$deviceID')";
            if($conn->query($sql1) === TRUE)
            {
                echo "New device added successfully";
            }
            else
            {
                echo "Error: " .$sql1 . "<br>" . $conn->error;
            }
        }
    }
    ?>
</body>
</html>


