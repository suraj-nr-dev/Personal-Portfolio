<?php
$host = "localhost";
$user = "root";
$password = ""; // default XAMPP password is empty
$dbname = "portfolio_db";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);

    if (isset($_FILES["resume"])) {
        $targetDirectory = "uploads/";
        $fileName = basename($_FILES["resume"]["name"]);
        $targetFile = $targetDirectory . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if ($fileType != "pdf") {
            echo "Only PDF files are allowed.";
            exit;
        }

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)) {
            // Insert into DB
            $sql = "INSERT INTO resume_uploads (name, email, file_name) VALUES ('$name', '$email', '$fileName')";
            if ($conn->query($sql) === TRUE) {
                echo "Resume uploaded and data saved successfully.";
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

$conn->close();
?>
