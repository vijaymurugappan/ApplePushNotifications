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
echo '<form name="notifying.php" action=';
echo $action;
echo ' method="POST">';
$csql = "select coursecode from courses";
//storing device ID
echo "<br>COURSE CODE";
    //selecting value from dropbox
    echo '<select name="coursecode" id="coursecode">';
    $result = $conn->query($csql);
    echo '<option value=""> </option>';
    //if the result returns more than 1 row which is some output then execute
    if ($result->num_rows > 0)
    {
        //fetching all row details
        while($row=$result->fetch_assoc())
        {
            echo "<option value='".$row["coursecode"]."'>".$row["coursecode"]."</option>";
        }
        echo '</select>';
    }

//Submit button
echo '<br><input type = "submit" value = "TRIGGER"><br><br>';
echo '</form>';
//Server Request check for post method
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Assigning values to table
	$courseCode = $_POST["coursecode"];
	if('$coursecode')
    {
        //Calculating the current time
        $currentTime = date("H:i",time());
		$sql1 = "select coursetime from courses where coursecode = '$courseCode'";
        $result1 = $conn->query($sql1);
        while($row=$result1->fetch_assoc())
        {
            $fetchString = $row["coursetime"];
            //Calculating half hour difference from database time
            $dateNew = strtotime($fetchString);
            $dateNew = $dateNew - 1800;
            $courseTime = date("H:i",$dateNew);
            //Trigger Notification
            if($currentTime == $courseTime)
            {
                $sql1 = "select deviceID from devices";
                $result1 = $conn->query($sql1);
                while($row=$result1->fetch_assoc())
                {
                    $deviceID = $row["deviceID"];
                $device_tokens_array = $deviceID;
                
                
                
                $message = "30 mins to class";
                
                $ctx = stream_context_create();
                stream_context_set_option($ctx, 'ssl', 'local_cert', 'pushCert.pem');
                stream_context_set_option($ctx, 'ssl', 'passphrase', "");
                
                // Open a connection to the APNS server
                $fp = stream_socket_client(
                                           'ssl://gateway.sandbox.push.apple.com:2195', $err,
                                           $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
                
                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);
                
                echo 'Connected to APNS' . PHP_EOL;
                
                // Create the payload body
                $body['aps'] = array(
                                     'alert' => $message,
                                     'sound' => 'default',
                                     'badge' => 1,
                                     );
                
                // Encode the payload as JSON
                $payload = json_encode($body);
                
                //    for($i=0; $i<=$device_tokens_array.length; $i++)
                //{
                // Build the binary notification
                $msg = chr(0) . pack('n', 32) . pack('H*', $device_tokens_array) . pack('n', strlen($payload)) . $payload;
                
                // Send it to the server
                $result = fwrite($fp, $msg, strlen($msg));
                //}
                
                if (!$result)
                    echo 'Message not delivered' . PHP_EOL;
                else
                    echo 'Message successfully delivered' . PHP_EOL;
                
                // Close the connection to the server
                fclose($fp);
              }
            }
          }
       }
    }
	// Put your device token here (without spaces):

?>
</body>
</html>




