<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch Value Test</title>
</head>
<body>
    <form action="chiprof.php" method="GET">
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

    // Fetch learner_id from caregiver table
    $columnName = "learner_id";
    $sql = "SELECT $columnName FROM caregiver WHERE user_id = :user_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $learner_id = $row[$columnName];
        echo "Value from $columnName: $learner_id "."<br>";
    }

    // Fetch points from learner table 
    $columnName = "points";
    $sql = "SELECT $columnName FROM learner WHERE user_id = :learner_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $points = $row[$columnName];
        echo "Value from $columnName: $points "."<br>";
    }


    // Fetch Cdays from learner table 
    $columnName = "Cdays";
    $sql = "SELECT $columnName FROM learner WHERE user_id = :learner_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $Cdays = $row[$columnName];
        echo "Value from $columnName: $Cdays "."<br>";
    }



    // Query to get the lesson name for the last Arabic progress of the student
    $sql = "SELECT l.lesson_name
    FROM lesson l
    JOIN aprogress a ON l.lesson_id = a.lesson_id
    WHERE a.learner_id = :learner_id
    ORDER BY a.lesson_id DESC
    LIMIT 1";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $Alesson_name = $row['lesson_name'];
        echo "Lesson name for the last progress: $Alesson_name "."<br>";
    } else {
        echo "No progress found for the student.";
    }


    // Query to get the lesson name for the last Eng progress of the student
    $sql = "SELECT l.lesson_name
    FROM lesson l
    JOIN eprogress a ON l.lesson_id = a.lesson_id
    WHERE a.learner_id = :learner_id
    ORDER BY a.lesson_id DESC
    LIMIT 1";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $Elesson_name = $row['lesson_name'];
        echo "Lesson name for the last progress: $Elesson_name"."<br>";
    } else {
        echo "No progress found for the student.";
    }


    // Query to get the lesson name for the last Number progress of the student
    $sql = "SELECT l.lesson_name
    FROM lesson l
    JOIN nprogress a ON l.lesson_id = a.lesson_id
    WHERE a.learner_id = :learner_id
    ORDER BY a.lesson_id DESC
    LIMIT 1";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nlesson_name = $row['lesson_name'];
        echo "Lesson name for the last progress: $nlesson_name"."<br>";
    } else {
        echo "No progress found for the student.";
    }





}
