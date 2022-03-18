<?php 

include 'function.php';
$pdo = pdo_connect_mysql();

if(isset($_POST['operation']))
{
    if($_POST["operation"] == "create")
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('dd-mm-YYYY');
        $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute(["auto", $name, $email, $phone, $title, $created]);
    }
    if($_POST["operation"] == "edit")
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('dd-mm-YYYY');
        $stmt = $pdo->prepare("UPDATE contacts VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute(["auto", $name, $email, $phone, $title, $created]);
    }
}

?>