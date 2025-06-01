<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json");

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = '4624163_lostfound';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);
$name = $data["name"];
$email = $data["email"];
$password = $data["password"];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $hashed_password);

try {
    $stmt->execute();
    $user_id = $stmt->insert_id;

    echo json_encode([
        "success" => true,
        "message" => "User registered successfully.",
        "user" => [
            "id" => $user_id,
            "name" => $name,
            "email" => $email
        ]
    ]);
} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1062) {
        echo json_encode(["success" => false, "message" => "Email already exists."]);
    } else {
        echo json_encode(["success" => false, "message" => "Registration failed.", "error" => $e->getMessage()]);
    }
}
exit;
?>

