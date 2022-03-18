<?php 

include 'function.php';
$pdo = pdo_connect_mysql();
if(isset($_POST["contacts_id"]))
{
    $contacts_id = $_POST["contacts_id"];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$contacts_id]);
}
?>