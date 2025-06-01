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
if (!$data || !isset($data["item_id"], $data["user1_id"], $data["user2_id"])) {
    echo json_encode(["success" => false, "message" => "Missing data"]);
    exit;
}

$item_id = $data["item_id"];
$user1 = $data["user1_id"];
$user2 = $data["user2_id"];

$sql = "SELECT sender_id, message, timestamp FROM messages
        WHERE item_id = ? AND 
        ((sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?))
        ORDER BY timestamp ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $item_id, $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(["success" => true, "messages" => $messages]);

$conn->close();
?>