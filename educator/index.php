<?php 

print_r($_POST);

$user_id = $_POST['educator_id'];
$material_id = $_POST['material_id'];
$group_id = $_POST['group_id'];
	
echo "<h2>Upload a file</h2>";
echo "<form action='upload.php' method='POST' enctype='multipart/form-data'>";
			
echo "<label for='file'>Select file</label>";
echo "<input type='file' name='file' id='file'>";
echo "<input type='hidden' name='educator_id' value='$user_id'>";
echo "<input type='hidden' name='material_id' value='$material_id'>";
echo "<input type='hidden' name='group_id' value='$group_id'>";
			
echo "<button type='submit'>Upload file</button>";

echo "</form>";


//==================================================================


// Show learners in my group
echo "<h2>learners</h2>";
echo "<form action='lenprof.php' method='GET'>";

require_once '../DataBase.php';

$db = Database::getConnection();

// Fetch the learner_id from lgroup table
$sqlSubject = "SELECT learner_id FROM `lgroup` WHERE group_id = :group_id";

$stmt_subject = $db->prepare($sqlSubject);
$stmt_subject->bindParam(':group_id', $group_id, PDO::PARAM_INT);
$stmt_subject->execute();

while ($row_subject = $stmt_subject->fetch(PDO::FETCH_ASSOC)) {
    $learner_id = $row_subject['learner_id'];
    echo "<button type='submit' name='learner_id' value='$learner_id'>Learner ID: $learner_id</button><br>";
}

echo "<input type='hidden' name='educator_id' value='$user_id'>";
echo "<input type='hidden' name='material_id' value='$material_id'>";
echo "<input type='hidden' name='group_id' value='$group_id'>";
echo "</form>";
?>
 