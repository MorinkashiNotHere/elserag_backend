<?php
// Connect to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elserag";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process audio feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["audio"]) && isset($_POST["user_id"]) && isset($_POST["role"])) {
    $user_id = $_POST["user_id"];
    $role = $_POST["role"];
    $date = date("Y-m-d");
    $feedback_name = $role . $user_id . "_" . date("mdY");

    // Get the audio file extension
    $audio_extension = pathinfo($_FILES["audio"]["name"], PATHINFO_EXTENSION);

    // Construct the new filename
    $new_filename = $feedback_name . "." . $audio_extension;

    // Save audio file with the new filename
    $target_dir = "records/";
    $target_file = $target_dir . $new_filename;
    move_uploaded_file($_FILES["audio"]["tmp_name"], $target_file);

    // Insert feedback into database
    $sql = "INSERT INTO feedback (user_id, role, date, feedback_name) VALUES ('$user_id', '$role', '$date', '$feedback_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Feedback recorded successfully.";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close MySQL connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
</head>
<body>
    <h2>Feedback Page</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        User ID: <input type="text" name="user_id" required><br><br>
        Role:
        <select name="role" required>
            <option value="learner">Learner</option>
            <option value="educator">Educator</option>
            <option value="caregiver">Caregiver</option>
        </select><br><br>
        Audio Feedback: <input type="file" name="audio" accept="audio/*" required><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
