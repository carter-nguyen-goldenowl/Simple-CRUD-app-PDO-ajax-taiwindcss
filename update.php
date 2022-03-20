<?php

include("function.php");
$pdo = pdo_connect_mysql();
extract($_POST);
if(isset($_POST['contacts_id']))
{

    $output = array();
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = '".$_POST["contacts_id"]."' LIMIT 1");
    $stmt->execute();
    $result = $stmt->fetchAll();

    foreach($result as $row)
    {
        $output['name'] = $row['name'];
        $output['email'] = $row['email'];
        $output['phone'] = $row['phone'];
        $output['title'] = $row['title'];
        $output['created'] = $row['created'];
        echo json_encode($output);
    }
}
?>