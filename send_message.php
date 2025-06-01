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
if (!$data || !isset($data["item_id"], $data["sender_id"], $data["receiver_id"], $data["message"])) {
    echo json_encode(["success" => false, "message" => "Missing data"]);
    exit;
}

$item_id = $data["item_id"];
$sender_id = $data["sender_id"];
$receiver_id = $data["receiver_id"];
$message = $data["message"];

// Insert message into DB
$sql = "INSERT INTO messages (item_id, sender_id, receiver_id, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $item_id, $sender_id, $receiver_id, $message);
$stmt->execute();

// Get receiver's email
$user_sql = "SELECT email FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $receiver_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$receiver_email = $user["email"] ?? null;

if ($receiver_email) {
    $subject = "New message about your lost/found item";
    $headers = "From: no-reply@csci410test.atwebpages.com";
    mail($receiver_email, $subject, $message, $headers);
}

echo json_encode(["success" => true, "message" => "Message sent"]);

$conn->close();
?>
