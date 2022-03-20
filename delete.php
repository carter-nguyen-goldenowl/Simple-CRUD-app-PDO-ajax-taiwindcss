<?php 

include 'function.php';
$pdo = pdo_connect_mysql();
if(isset($_POST["contacts_id"]))
{
    $id = $_POST["contacts_id"];
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
}
?>