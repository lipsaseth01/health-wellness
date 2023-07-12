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
  // Get the email ID from the form
  $email = $_POST["email"];

  // Retrieve user details from the database based on email ID
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // User found, fetch the details
    $user = $result->fetch_assoc();
    $user_id = $user["id"];

    // Retrieve the file details from the database based on the user ID
    $sql = "SELECT * FROM files WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // File found, display the details and provide a download link
      $file = $result->fetch_assoc();
      $filename = $file["filename"];
      $file_path = "uploads/" . $filename; // Path to the uploaded file

      echo "<h2>User Details:</h2>";
      echo "Name: " . $user["name"] . "<br>";
      echo "Age: " . $user["age"] . "<br>";
      echo "Weight: " . $user["weight"] . "<br>";
      echo "Email: " . $user["email"] . "<br>";

      echo "<h2>Health Report:</h2>";
      echo "File Name: " . $filename . "<br>";
      echo "File Size: " . filesize($file_path) . " bytes<br>";
      echo "Download: <a href='$file_path' download>Click Here</a>";
    } else {
      echo "No health report found for the provided email ID.";
    }
  } else {
    echo "No user found for the provided email ID.";
  }
}

// Close the database connection
$conn->close();
