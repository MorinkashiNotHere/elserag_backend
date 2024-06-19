<?php
include 'db.php';

$user = isset($_GET['user']) ? $_GET['user'] : 'YourName';

$stmt = $conn->prepare("SELECT filename, timestamp FROM recordings WHERE user = :user ORDER BY timestamp ASC");
$stmt->bindParam(':user', $user);
$stmt->execute();

$recordings = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $recordings[] = [
        'name' => $row['filename'],
        'url' => 'uploads/' . $row['filename'],
        'timestamp' => $row['timestamp']
    ];
}

header('Content-Type: application/json');
echo json_encode($recordings);
?>
