<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Role Assignment</title>
</head>
<body>
    <h2>User Role Assignment</h2>
    <ul>
        
        
    </ul>

    <div id="user-role-tab">
        <form method="post" action="feedback1.php">
            <label for="userID">User ID:</label><br>
            <input type="text" id="userID" name="userID" required><br><br>
            
            <label for="role">Select Role:</label><br>
            <select id="role" name="role">
                <option value="learner">Learner</option>
                <option value="educator">Educator</option>
                <option value="caregiver">Caregiver</option>
            </select><br><br>
            
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // Check if form is submitted
        if(isset($_POST['submit'])) {
            // Retrieve user input
            $userID = $_POST['userID'];
            $role = $_POST['role'];

            // Validate user input (you can add more validation as per your requirements)
            if(!empty($userID) && !empty($role)) {
                // Connect to your database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "elserag";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare and bind SQL statement
                $stmt = $conn->prepare("INSERT INTO feedback (user_id, role) VALUES (?, ?)");
                $stmt->bind_param("ss", $userID, $role);

                // Execute SQL statement
                if ($stmt->execute() === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close statement and database connection
                $stmt->close();
                $conn->close();
            } else {
                echo "Please fill in all fields";
            }
        }
        ?>
    </div>
</body>
</html>
