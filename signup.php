<?php

require_once './DataBase.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jsonString = file_get_contents("php://input");
    
    $data = json_decode($jsonString);
        
    if (isset($data->user_id, $data->password, $data->role)) {
        $user_id = $data->user_id;
        $password = $data->password;
        $role = $data->role;
        
        $SubjectSpecialization = null; // Initialize to null
        $learner_id = null;

        if ($role == "educator") {
            $SubjectSpecialization = $data->SubjectSpecialization;
        }
        if ($role == "caregiver") {
            $learner_id = $data->learner_id;
                        
            if (isUseridExist($learner_id,"learner") == false) {
                echo json_encode([
                    "message" => "Learner doesn't exists"
                ]);

                exit();
            }
        }

        if (isUseridExist($user_id, $role)) {
            echo json_encode([
                "status" => "failure",
                "message" => "User already exists"
            ]);
        } else {
            $db = Database::getConnection();

            if ($role == "educator") {
                $query = "INSERT INTO $role (user_id, password, SubjectSpecialization) VALUES (:user_id, :password, :SubjectSpecialization)";
            } elseif ($role == "caregiver") {
                $query = "INSERT INTO $role (user_id, password, learner_id) VALUES (:user_id, :password, :learner_id)";
            } else {
                $query = "INSERT INTO $role (user_id, password) VALUES (:user_id, :password)";
            }

            $statement = $db->prepare($query);

            if ($role == "educator") {
                $isSuccess = $statement->execute([
                    "user_id" => $user_id,
                    "password" => password_hash($password, PASSWORD_DEFAULT),
                    "SubjectSpecialization" => $SubjectSpecialization
                ]);
            } elseif ($role == "caregiver") {
                $isSuccess = $statement->execute([
                    "user_id" => $user_id,
                    "password" => password_hash($password, PASSWORD_DEFAULT),
                    "learner_id" => $learner_id
                ]);
            } else {
                $isSuccess = $statement->execute([
                    "user_id" => $user_id,
                    "password" => password_hash($password, PASSWORD_DEFAULT)
                ]);
            }

            if ($isSuccess) {
                $response = [
                    "status" => "success",
                    "message" => "User has been created successfully"
                ];
            } else {
                $response = [
                    "status" => "failure",
                    "message" => "Something went wrong!"
                ];
            }

            echo json_encode($response);
        }
    } else {
        echo json_encode([
            "status" => "failure",
            "message" => "Invalid JSON data. Make sure user_id, password, and role properties are provided."
        ]);
    }
}

function isUseridExist($user_id, $role)
{
    $db = Database::getConnection();
    $query = "SELECT * FROM $role WHERE user_id = :user_id";
    $statement = $db->prepare($query);
    $statement->execute([
        ":user_id" => $user_id
    ]);

    return $statement->fetch() !== false;
}
?>
