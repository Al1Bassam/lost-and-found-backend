<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = '4624163_lostfound';  // the DB you imported earlier

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["user_id"], $data["title"], $data["description"], $data["category"], $data["status"])) {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$user_id = $data["user_id"];
$title = $data["title"];
$description = $data["description"];
$category = $data["category"];
$status = $data["status"];

$sql = "INSERT INTO items (user_id, title, description, category, status)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issss", $user_id, $title, $description, $category, $status);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Item posted"]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
