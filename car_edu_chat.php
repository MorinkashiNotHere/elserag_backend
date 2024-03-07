<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Value Test</title>
</head>

<body>
    <form action="car_edu_chat.php" method="GET">
        <label for="id">Enter ID:</label>
        <input type="text" name="user_id" id="id" required>
        <button type="submit">Fetch Value</button>
    </form>
</body>

</html>

<?php

require_once './DataBase.php';

$db = Database::getConnection();

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch educator_id from care_edu table
    $columnName = "educator_id";
    $sql = "SELECT $columnName FROM care_edu WHERE caregiver_id = :user_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $educator_id = $row[$columnName];
        echo "Value from educator_id: $educator_id<br>";
        
        // Fetch SubjectSpecialization from educator table
        $columnNameSubject = "SubjectSpecialization";
        $sqlSubject = "SELECT $columnNameSubject FROM educator WHERE user_id = :educator_id";

        $stmt_subject = $db->prepare($sqlSubject);
        $stmt_subject->bindParam(':educator_id', $educator_id, PDO::PARAM_INT);
        $stmt_subject->execute();

        while ($row_subject = $stmt_subject->fetch(PDO::FETCH_ASSOC)) {
            $SubjectSpecialization = $row_subject[$columnNameSubject];
            echo "Value from SubjectSpecialization: $SubjectSpecialization<br>";
        }
    }
}

?>
