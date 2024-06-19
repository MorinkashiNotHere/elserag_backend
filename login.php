<?php

require_once './DataBase.php';
require_once './vendor/autoload.php'; // Include the JWT library
use Firebase\JWT\JWT;

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
            $token = generateJWT($user['user_id'], $role); // Generate JWT token
            $response = [
                "status" => "success",
                "message" => "login success",
                "user" => [
                    "user_id" => $user['user_id'],
                ],
                "token" => $token // Include the token in the response
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

// Function to generate JWT token
function generateJWT($user_id, $role) {
    $payload = array(
        "user_id" => $user_id,
        "role" => $role,
        "exp" => time() + (60*60*24) // Token expiration time (24 hours)
    );
    $secret_key = base64_encode(random_bytes(32)); ; // Change this to a strong secret key
    $token = JWT::encode($payload, $secret_key,'HS256');
    return $token;
}
?>
