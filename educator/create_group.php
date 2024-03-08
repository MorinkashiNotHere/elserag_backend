<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create group</title>
</head>

<body>
    <form action="create_group.php" method="POST">
        <label for="id">create group:</label>
        <input type="text" name="user_id" id="id" required>
        <button name="create" type="submit">create</button>
    </form>
</body>

</html>

<?php

require_once '../DataBase.php';

$db = Database::getConnection();

if (isset($_POST['create'])) {

    $user_id = $_POST['user_id'];
    $SubjectSpecialization = ''; // Initialize it before the first query

    // Fetch SubjectSpecialization from educator table
    $columnNameSubject = "SubjectSpecialization";
    $sqlSubject = "SELECT $columnNameSubject FROM educator WHERE user_id = :educator_id";

    $stmt_subject = $db->prepare($sqlSubject);
    $stmt_subject->bindParam(':educator_id', $user_id, PDO::PARAM_INT);
    $stmt_subject->execute();

    while ($row_subject = $stmt_subject->fetch(PDO::FETCH_ASSOC)) {
        $SubjectSpecialization = $row_subject[$columnNameSubject];
        echo "Value from SubjectSpecialization: $SubjectSpecialization<br>";
    }

    // Fetch material_id from material table
    $columnName = "material_id";
    $sql = "SELECT $columnName FROM material WHERE Title = :subjectSpecialization";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':subjectSpecialization', $SubjectSpecialization, PDO::PARAM_STR);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $material_id = $row[$columnName];
        echo "Value from $columnName: $material_id " . "<br>";

        // Insert into group table
        $sqlInsert = "INSERT INTO `group` (educator_id, material_id) VALUES (:user_id, :material_id)";
        $stmtInsert = $db->prepare($sqlInsert);
        $stmtInsert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmtInsert->bindParam(':material_id', $material_id, PDO::PARAM_INT);
        $stmtInsert->execute();

        echo "Inserted into group table successfully.<br>";

        // Fetch group_id from group table
        $columnName = "group_id";
        $sqlGroup = "SELECT $columnName FROM `group` WHERE educator_id = :user_id AND complete = 'no'";

        $stmt_group = $db->prepare($sqlGroup);
        $stmt_group->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_group->execute();

        while ($row_group = $stmt_group->fetch(PDO::FETCH_ASSOC)) {
            $group_id = $row_group[$columnName];
            echo "Value from group_id: $group_id<br>";

            // Fetch learner_id from learner table based on material_id (LIMIT 6)
            $learner_id = ''; // Initialize it before the first query
            $group_column_name = ''; // Initialize the group-specific column name

            // Determine the group-specific column name based on material_id
            switch ($material_id) {
                case 1:
                    $group_column_name = "Agroup";
                    break;
                case 2:
                    $group_column_name = "Egroup";
                    break;
                case 3:
                    $group_column_name = "Ngroup";
                    break;
                case 4:
                    $group_column_name = "Sgroup";
                    break;
            }

            // Fetch learner_id from learner table where the specific group column is 'no' (LIMIT 6)
            $columnName = "user_id";
            $sqlLearner = "SELECT $columnName FROM learner WHERE $group_column_name = 'no' LIMIT 6";

            $stmt_learner = $db->prepare($sqlLearner);
            $stmt_learner->execute();

            $learnerCount = 0; // Initialize learner count

            while ($row_learner = $stmt_learner->fetch(PDO::FETCH_ASSOC)) {
                $learner_id = $row_learner[$columnName];
                echo "Value from learner_id: $learner_id<br>";
                $learnerCount++;

                // Fetch caregiver_id from caregiver table based on learner_id
                $caregiver_id = ''; // Initialize it before the query
                $sqlCaregiver = "SELECT user_id FROM caregiver WHERE learner_id = :learner_id";

                $stmt_caregiver = $db->prepare($sqlCaregiver);
                $stmt_caregiver->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
                $stmt_caregiver->execute();

                while ($row_caregiver = $stmt_caregiver->fetch(PDO::FETCH_ASSOC)) {
                    $caregiver_id = $row_caregiver['user_id'];
                    echo "Value from caregiver_id: $caregiver_id<br>";

                    // Insert into cgroup table
                    $sqlInsertCgroup = "INSERT INTO cgroup (group_id, caregiver_id) VALUES (:group_id, :caregiver_id)";
                    $stmtInsertCgroup = $db->prepare($sqlInsertCgroup);
                    $stmtInsertCgroup->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                    $stmtInsertCgroup->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
                    $stmtInsertCgroup->execute();

                    echo "Inserted into cgroup table successfully.<br>";

                    // Insert into care_edu table
                    $sqlInsertCgroup = "INSERT INTO care_edu (educator_id, caregiver_id) VALUES (:user_id, :caregiver_id)";
                    $stmtInsertCgroup = $db->prepare($sqlInsertCgroup);
                    $stmtInsertCgroup->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmtInsertCgroup->bindParam(':caregiver_id', $caregiver_id, PDO::PARAM_INT);
                    $stmtInsertCgroup->execute();

                    echo "Inserted into care_edu table successfully.<br>";

                }

                // Insert into lgroup table
                $sqlInsertLgroup = "INSERT INTO lgroup (group_id, learner_id) VALUES (:group_id, :learner_id)";
                $stmtInsertLgroup = $db->prepare($sqlInsertLgroup);
                $stmtInsertLgroup->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                $stmtInsertLgroup->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
                $stmtInsertLgroup->execute();

                echo "Inserted into lgroup table successfully.<br>";

                // Update the group-specific column in learner table to 'yes'
                $sqlUpdateLearner = "UPDATE learner SET $group_column_name = 'yes' WHERE user_id = :learner_id";
                $stmtUpdateLearner = $db->prepare($sqlUpdateLearner);
                $stmtUpdateLearner->bindParam(':learner_id', $learner_id, PDO::PARAM_INT);
                $stmtUpdateLearner->execute();

                echo "Updated $group_column_name column in learner table to 'yes' successfully.<br>";
            }

            if ($learnerCount > 0) {
                // Update complete column in group table to 'yes'
                $sqlUpdateComplete = "UPDATE `group` SET complete = 'yes' WHERE group_id = :group_id";
                $stmtUpdateComplete = $db->prepare($sqlUpdateComplete);
                $stmtUpdateComplete->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                $stmtUpdateComplete->execute();

                echo "Updated complete column in group table to 'yes' successfully.<br>";
            } else {
                // No learners found, delete the group row
                $sqlDeleteGroup = "DELETE FROM `group` WHERE group_id = :group_id";
                $stmtDeleteGroup = $db->prepare($sqlDeleteGroup);
                $stmtDeleteGroup->bindParam(':group_id', $group_id, PDO::PARAM_INT);
                $stmtDeleteGroup->execute();

                echo "No learners found. Deleted the group row.<br>";
            }
        }
    }
}
?>

