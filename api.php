<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (empty($data["snack"]) || empty($data["cash"]) || empty($data["quantity"])) {
    echo json_encode(["success" => false, "message" => "Please fill in all fields."]);
    exit;
}

$snack = strtolower($data["snack"]);
$quantity = (int)$data["quantity"];
$cash = (int)$data["cash"];

// Snack prices
$prices = [
    "richee" => 8,
    "curlytops" => 25,
    "pompoms" => 1
];

if (!isset($prices[$snack])) {
    echo json_encode(["success" => false, "message" => "Invalid snack."]);
    exit;
}

// Calculate total
$total = $prices[$snack] * $quantity;

// Check payment
if ($cash < $total) {
    echo json_encode([
        "success" => false,
        "message" => "Insufficient cash. You need ₱" . ($total - $cash) . " more."
    ]);
} else {
    $change = $cash - $total;
    echo json_encode([
        "success" => true,
        "message" => "Purchase successful!",
        "total" => $total,
        "change" => $change
    ]);
}
?>
