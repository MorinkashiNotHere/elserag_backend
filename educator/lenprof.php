<?php

require_once '../DataBase.php';

$db = Database::getConnection();

print_r($_GET);

$educator_id = $_GET['educator_id'];
$material_id = $_GET['material_id'];
$group_id = $_GET['group_id'];
$user_id = $_GET['learner_id'];


// Fetch points from learner table 
$columnName = "points";
$sql = "SELECT $columnName FROM learner WHERE user_id = :user_id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $points = $row[$columnName];
    echo "Value from $columnName: $points "."<br>";
}


// Fetch Cdays from learner table 
$columnName = "Cdays";
$sql = "SELECT $columnName FROM learner WHERE user_id = :user_id";

$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $Cdays = $row[$columnName];
    echo "Value from $columnName: $Cdays "."<br>";
}


//==============================================================================

$learner_id = $user_id;
if($material_id==1){
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
}
elseif($material_id==2){
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
}
elseif($material_id==3){
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

//===================================================================

echo "<h2>chat caregiver</h2>";
echo "<form action='edu_care_chat.php' method='POST'>";
echo "<input type='hidden' name='educator_id' value='$educator_id'>";
echo "<input type='hidden' name='material_id' value='$material_id'>";
echo "<input type='hidden' name='group_id' value='$group_id'>";
echo "<input type='hidden' name='learner_id' value='$learner_id'>";
echo "<button type='submit' name='chat' >chat</button><br>";

echo "</form>";

echo "<h2>chat learner</h2>";
echo "<form action='edu_learner_chat.php' method='POST'>";
echo "<input type='hidden' name='educator_id' value='$educator_id'>";
echo "<input type='hidden' name='material_id' value='$material_id'>";
echo "<input type='hidden' name='group_id' value='$group_id'>";
echo "<input type='hidden' name='learner_id' value='$learner_id'>";
echo "<button type='submit' name='chat' >chat</button><br>";

echo "</form>";

echo "<h2>assignment</h2>";
echo "<form action='assignment.php' method='POST'>";
echo "<input type='hidden' name='educator_id' value='$educator_id'>";
echo "<input type='hidden' name='material_id' value='$material_id'>";
echo "<input type='hidden' name='group_id' value='$group_id'>";
echo "<input type='hidden' name='learner_id' value='$learner_id'>";
echo "<button type='submit' name='chat' >assignment</button><br>";

echo "</form>";


?>