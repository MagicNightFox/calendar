<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    // Check if username is empty or contains only spaces
    if (trim($username) === '' || ctype_space($username) || empty(trim($username))) {
        header("Location: index.html"); // Redirect to index if username is empty or contains only spaces
        exit();
    }

    // Check if username has spaces
    if (strpos($username, ' ') !== false) {
        header("Location: index.html"); // Redirect to index if username contains spaces
        exit();
    }

    // Validate username and redirect to calendar if valid
    $clean_username = htmlspecialchars($username);
    setcookie("user_cookie", $username, 0, "/");
    header("Location: calendar.php"); // Redirect to calendar
    exit();
}
?>
