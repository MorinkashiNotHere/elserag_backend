<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>showgroupedu</title>
</head>

<body>
    <form action="showgroupedu.php" method="GET">
        <label for="id">showgroupedu:</label>
        <input type="text" name="user_id" id="id" required>
        <button name="show" type="submit">show</button>
    </form>
</body>

</html>

<?php

require_once '../DataBase.php';

$db = Database::getConnection();

if (isset($_GET['show'])) {

    $user_id = $_GET['user_id'];
    

    // Fetch the group_id and material_id from group table
    $sqlSubject = "SELECT group_id, material_id FROM `group` WHERE educator_id = :user_id";

    $stmt_subject = $db->prepare($sqlSubject);
    $stmt_subject->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_subject->execute();



    echo "<form action='index.php' method='POST'>";
    echo "<input type='hidden' name='educator_id' value='$user_id'>";
    while ($row_subject = $stmt_subject->fetch(PDO::FETCH_ASSOC)) {
        $group_id = $row_subject['group_id'];
        $material_id = $row_subject['material_id'];
        echo " Value from material_id: $material_id<br>";
        echo "<button name='group_id' type='submit' value='$group_id'> $group_id </button>";
    }
    echo "<input type='hidden' name='material_id' value='$material_id'>";
    echo "</form>";
}
?>
