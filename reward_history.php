<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Výhra!!</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        .flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
        .reward_page {
            text-align: center;
        }
        .win_container {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 500px;
            padding: 50px;
            box-shadow: 0px 0px 20px 12px white;
            display: grid;
            justify-content: center;
            align-items: center;
            transition: transform 1s;
        }
        a {
            color: black;
            text-decoration: none;
            cursor: pointer;
            transition: transform 1s;
        }
        a:hover > .win_container{
            transform: scale(1.1);
        }

        @media only screen and (max-width: 448px) {
            
    h1{
        font-size: 18pt;
    }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 449px) and (max-width: 768px) {
    .win_container{
        width: 300px;
        height: 300px;
    }
    h1{
        font-size: 32pt;
    }
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 769px) {
    .win_container{
        width: 600px;
        height: 600px;
    }
    h1{
        font-size: 64pt;
    }
}

    </style>
</head>
<body>
    <div class ="flex-container">
    <div class="reward_page">
    <a href="https://www.google.com/url?sa=t&rct=j&q=&esrc=s&source=web&cd=&ved=2ahUKEwj36tKSh-2CAxVbgv0HHZWNCZIQFnoECAcQAQ&url=https%3A%2F%2Fstaj.ufonek.net%2F&usg=AOvVaw06yyy0HzqAPwcskritaapW&opi=89978449">
    <div class="win_container">
<h1>ODMĚNA</h1>
<?php 

if (isset($_COOKIE["user_cookie"])) {
    $inputted_username = $_COOKIE["user_cookie"];
    
} else {
    echo "Cookie not set or expired";
    header("Location: index.html");
    exit();
}


if (isset($_GET['day'])) {
    $received_day = urldecode($_GET['day']);
   // echo "Received day: " . $received_day;
} else {
    echo "Day not set";
}


// Assuming you have a database connection established
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


// Query database to get the user's data
$sql = "SELECT * FROM advent_calendar WHERE username = '$inputted_username'";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // User found, display their calendar data
    $row = $result->fetch_assoc();
    // Display the calendar data as needed

}

$day_status = $row["day_$received_day"];
if($day_status == 0){
    echo "<h2 style='color: red'> Tuto odměnu jsi zmeškal/a :( </h2>";
}
else{
    echo "<h2 style='color: green'> Tuto odměnu jsi již získal/a :) </h2>";
}



/*
if(date('j')>24){
    $currentDay =24;
}
else{
    $currentDay = date('j');
}
*/





$sql = "SELECT d" . $received_day . " FROM advent_rewards WHERE id = '1'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Access the value from the fetched row
    $textElement = $row["d" . $received_day];
    
    echo "<h1>" . $textElement . "</h1>";
} else {
    echo "Ajaj, něco se pokazilo! Vyscreenuj to a pošli to vedoucí :)";
}



$conn->close();
?>


</div></a>
</div>
</div>
</body>
</html>