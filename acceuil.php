<?php

session_start();
require_once('db.class.php');
require_once('user.class.php');

$db = new Database('localhost', 'taxi', 'root', '');
$connexion = $db->connect();


foreach ($_SESSION['user'] as $user) {

    echo " Bienvenue sur E-TaxiBOKKO" . " " . $user['nom'] . " " . $user['prenom'];
}

if (isset($_POST['deconnect'])) {
    session_unset();
    session_destroy();
    header('location:index.php');
    exit;
}

if (isset($_POST['user'])) {
    $user = Utilisateur::listeUser($connexion);

    $_SESSION['liste'] = $user;

    header('location:users.php');

    var_dump($user);
    die;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <br>
    <br>
    <br>
    <div id="user">

        <form action="" method="post">
            <input id="us" type="submit" name="user" value="Listes des utilisateurs">
        </form>

    </div>
    <br>
    <br>
    <br>
    <form action="" method="post">
        <input type="submit" name="deconnect" id="deconnect" value="Deconnexion">

    </form>

</body>

</html>