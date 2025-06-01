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

// Get optional filters
$status = isset($_GET["status"]) ? $_GET["status"] : null;
$category = isset($_GET["category"]) ? $_GET["category"] : null;

$sql = "SELECT items.*, users.name, users.email
        FROM items
        JOIN users ON items.user_id = users.id
        WHERE 1=1";

$params = [];
$types = "";

if ($status) {
    $sql .= " AND items.status = ?";
    $types .= "s";
    $params[] = $status;
}

if ($category) {
    $sql .= " AND items.category = ?";
    $types .= "s";
    $params[] = $category;
}

$stmt = $conn->prepare($sql);
if ($types !== "") {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode(["success" => true, "items" => $items]);

$conn->close();
?>
