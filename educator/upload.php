<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
    $educator_id = $_POST['educator_id'];
    $material_id = $_POST['material_id'];
    $group_id = $_POST['group_id'];
    $file_subject = $_POST['file_subject'];

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = array("txt", "docx", "pdf");
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only txt, docx, and PDF files are allowed.";
        } else {

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];
                $upload_date = date("Y-m-d H:i:s"); // Current date and time

                $db_host = "localhost";
                $db_user = "root";
                $db_pass = "";
                $db_name = "elserag";

                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO upload_material (filename, filesize, filetype, educator_id, material_id, group_id, file_subject, date) VALUES ('$filename', $filesize, '$filetype', $educator_id, $material_id, $group_id, '$file_subject', '$upload_date')";

                if ($conn->query($sql) === TRUE) {
                    echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded, and the information has been stored in the database.";
                } else {
                    echo "Sorry, there was an error uploading your file and storing information in the database: " . $conn->error;
                }

                $conn->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }
}
?>
