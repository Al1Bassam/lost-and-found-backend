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
if (!$data || !isset($data["user_id"])) {
    echo json_encode(["success" => false, "message" => "Missing user ID"]);
    exit;
}

$user_id = $data["user_id"];

$sql = "SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(["success" => true, "items" => $items]);

$conn->close();
?>
