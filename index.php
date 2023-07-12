<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get user details from the form
  $name = $_POST["name"];
  $age = $_POST["age"];
  $weight = $_POST["weight"];
  $email = $_POST["email"];
  $pdf = $_POST["healthReport"];

  // Insert user details into the database
  $sql = "INSERT INTO users (name, age, weight, email, healthreport) VALUES ('$name', '$age', '$weight', '$email', '$healthReport')";
  if ($conn->query($sql) === TRUE) {
    $user_id = $conn->insert_id; // Get the ID of the inserted user

    // Process uploaded file
    $file = $_FILES["health-report"];
    $filename = $file["name"];
    $temp_path = $file["tmp_name"];
    $destination = "uploads/" . $filename; // Directory to save the uploaded file

    // Move the uploaded file to the destination directory
    if (move_uploaded_file($temp_path, $destination)) {
      // Insert file details into the database
      $sql = "INSERT INTO files (user_id, filename) VALUES ('$user_id', '$filename')";
      if ($conn->query($sql) === TRUE) {
        echo "User details and file uploaded successfully.";
      } else {
        echo "Error inserting file details: " . $conn->error;
      }
    } else {
      echo "Error uploading file.";
    }
  } else {
    echo "Error inserting user details: " . $conn->error;
  }
}

// Close the database connection
$conn->close();
