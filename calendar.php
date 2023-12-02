<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main">
<?php

//check today's date
if(date('j')>25){
    $currentDay =25;
}
else{
    $currentDay = date('j');
}

// check if user has username inputted
if (isset($_COOKIE["user_cookie"])) {
    $inputted_username = $_COOKIE["user_cookie"];

} else {
    echo "Cookie not set or expired";
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ufonek_advent";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//nastav, že je to unclaimnutý, když si to nevyzvedne včas:

for ($day = 1; $day<$currentDay; $day++){
    $sql = "UPDATE advent_calendar SET day_$day = 0 WHERE username = '$inputted_username' AND day_$day = -1";
    $conn->query($sql);
}



// Query database to get the user's data
$sql = "SELECT * FROM advent_calendar WHERE username = '$inputted_username'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // User found, display their calendar data
    $row = $result->fetch_assoc();
    // Display the calendar data as needed

?>
<div class="user_stats">
<h1><?php echo $inputted_username ?></h1>
<div class="horizontal_divider"><hr></div>
<div class="container_small_days">
  <?php
  for($day = 1; $day<25;$day++){
    $day_status = $row["day_$day"];

    

    switch($day_status){
        case -1: 
            echo '<div class="box gray"></div>';
            break;
        
        case 0:
            echo '<div class="box red"><div class="line"></div></div>';
            break;

        case 1:
            echo '<div class="box green"></div>';
            break;

        default: 
            echo '<div class="box gray"></div>';
            break;
    }
}
  ?>
</div>
</div>


<div class="calendar-container">
<?php 
$arrayOfDays = [12, 3, 20, 6, 1, 24, 9, 18, 4, 15, 7, 11, 23, 2, 14, 5, 19, 8, 22, 17, 10, 13, 21, 16];
foreach ($arrayOfDays as $day){
    $randomNumber = rand(1, 9);
    $day_status = $row["day_$day"];
    switch($day_status){
        case -1: 
            if($currentDay == $day){
                echo '<a href="reward.php"><div class=cell id="day-1">
            <div class="front")">
            <img src="img/christmas-' . $randomNumber . '.png" />
            <p>'. $day .'</p>
            </div>
            <div class="back"></div>
        </div></a>';
            }
            else{
                echo '<div class=cell id="day-1">
            <div class="front")">
            <img src="img/christmas-' . $randomNumber . '.png" />
            <p>'. $day .'</p>
            </div>
            <div class="back"></div>
        </div>';
            }
            break;
        
        case 0:
            echo '<div class=cell id="day0">
            <div class="back unclaimed"><p>'. $day .'</p> </div>
        </div>';
            break;

        case 1:
            echo '<div class=cell id="day1">
            <div class="back claimed"><p>'. $day .'</p></div>
        </div>';
            break;

        default: 
        echo '<div class=cell id="day-1">
        <div class="front")">
        <img src="img/christmas-' . $randomNumber . '.png" />
        <p>'. $day .'</p>
        </div>
        <div class="back"></div>
    </div>';
            break;
    }
}

?>

</div>


<?php

} else {
    // User not found, create a new entry in the database
    $sql_insert = "INSERT INTO advent_calendar (username) VALUES ('$inputted_username')";
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: calendar.php");
        // Entry created successfully
    } else {
        // Error creating entry
    }
}

$conn->close();

?>

    </div>
</body>
</html>

