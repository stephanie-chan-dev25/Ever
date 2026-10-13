<?php include("connection.php");?>
<?php
$id = $_GET["id"];
$sql = $conn->prepare("SELECT * FROM food WHERE id = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();
$row = $result->fetch_assoc();

session_start();

if (!isset($_SESSION["productIds"])) {
    $_SESSION["productIds"] = [];
}
$_SESSION["productIds"][] = $id;

if (!isset($_SESSION["productNames"])) {
    $_SESSION["productNames"] = [];
}
$_SESSION["productNames"][] = $row["name"];

if (!isset($_SESSION["productQuantities"])) {
    $_SESSION["productQuantities"] = [];
}
$_SESSION["productQuantities"][] = $row["quantity"];

if (!isset($_SESSION["productPrices"])) {
    $_SESSION["productPrices"] = [];
    $_SESSION["total"] = 0;
}
$_SESSION["productPrices"][] = $row["price"];
$_SESSION["total"] += $row["price"];

header("Location: cart.php");
exit();
?>