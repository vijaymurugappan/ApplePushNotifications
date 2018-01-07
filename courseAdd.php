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
    echo '<form name="courseAdd.php" action=';
    echo $action;
    echo ' method="POST">';
    echo "COURSE NAME";
    //Creating text box for getting inputs from user
    echo '<br><input type="text" name="coursename">';
    echo "<br>COURSE CODE";
    echo '<br><input type="text" name="coursecode">';
    echo "<br>TIME";
    echo '<br><input type="text" name="coursetime">';
    //Submit button
    echo '<br><input type = "submit" value = "ENROLL COURSE"><br><br>';
    echo '</form>';
    //Server Request check for post method
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //Assigning values to table
        $courseName = $_POST["coursename"];
        $courseCode = $_POST["coursecode"];
        $courseTime = $_POST["coursetime"];
        if('$courseName' && '$coursecode' && '$coursetime')
        {
            
            $sql1 = "insert into courses(coursename,coursecode,coursetime)values('$courseName','$courseCode','$courseTime')";
            if($conn->query($sql1) === TRUE)
            {
                echo "New record created successfully";
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

