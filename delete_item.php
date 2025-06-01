<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = '4624163_lostfound';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data["item_id"])) {
    echo json_encode(["success" => false, "message" => "Missing item ID"]);
    exit;
}

$item_id = $data["item_id"];

try {
    // First: delete related messages
    $deleteMessages = $conn->prepare("DELETE FROM messages WHERE item_id = ?");
    $deleteMessages->bind_param("i", $item_id);
    $deleteMessages->execute();

    // Then: delete the item itself
    $deleteItem = $conn->prepare("DELETE FROM items WHERE id = ?");
    $deleteItem->bind_param("i", $item_id);
    $deleteItem->execute();

    echo json_encode(["success" => true, "message" => "Item and related messages deleted"]);
} catch (mysqli_sql_exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Failed to delete item",
        "error" => $e->getMessage()
    ]);
}

$conn->close();
?>
