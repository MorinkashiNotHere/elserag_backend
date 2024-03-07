<?php

require_once './DataBase.php';
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = Database::getConnection();
    $jsonString = file_get_contents("php://input");

    $data = json_decode($jsonString);

    $user_id = $data->user_id;
    $password = $data->password;
    $role = $data->role;

    $checkIfUserExist = "SELECT * FROM $role WHERE user_id = :user_id";
    $statement = $db->prepare($checkIfUserExist);
    $statement->execute([
        ":user_id" => $user_id,
    ]);

    if ($statement->rowCount() > 0) {
        $user = $statement->fetch();
        $dbpassword = $user['password'];
        if (password_verify($password, $dbpassword)) {
            $response = [
                "status" => "success",
                "message" => "login success",
                "user" => [
                    "user_id" => $user['user_id'],
                ]
            ];

        } else {

            $response = [
                "status" => "failure",
                "message" => "incorrect username or password"
            ];

        }

    } else {
        $response = [
            "status" => "failure",
            "message" => "incorrect username or password"
        ];
    }

    echo json_encode($response);
}
?>
