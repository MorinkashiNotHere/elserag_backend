<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['audio']) && $_FILES['audio']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filename = basename($_FILES['audio']['name']);
        $uploadFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadFile)) {
            $user = $_POST['user'];

            // Insert recording metadata into the database
            $stmt = $conn->prepare("INSERT INTO recordings (filename, user) VALUES (:filename, :user)");
            $stmt->bindParam(':filename', $filename);
            $stmt->bindParam(':user', $user);
            $stmt->execute();

            echo json_encode(['status' => 'success', 'message' => 'File uploaded and metadata stored successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded or there was an upload error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
