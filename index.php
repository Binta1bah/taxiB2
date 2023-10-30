<?php

session_start();
//require('chageur.php');


require_once('db.class.php');
require_once('user.class.php');


$db = new Database('localhost', 'taxi', 'root', '');
$connexion = $db->connect();
// var_dump($connexion);

if (isset($_POST['inscription'])) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['tel'];
    $mail = $_POST['email'];
    $pass = $_POST['passe'];
    $erreursIns = [];


    $sql1 = ("SELECT * FROM users WHERE email = :mail ");

    $select = $connexion->prepare($sql1);

    $select->bindParam(':mail', $mail);

    $select->execute();

    $retour = $select->fetchAll();

    if ($retour) {
        $erreursIns[] = "Cet email est déjà utilisée";
    } else {

        $user = new Utilisateur($nom, $prenom, $telephone, $mail, $pass);

        try {
            $message = $user->inscription($connexion);
            echo $message;
        } catch (PDOException $e) {
            echo "L'inscription n'a pas reussi" . $e->getMessage();
        }
    }
}


if (isset($_POST['connexion'])) {
    $email = $_POST['mail'];
    $passe = $_POST['pass'];
    $passcrypt = md5($passe);

    $conn = Utilisateur::seConnecter($email, $passcrypt, $connexion);

    $_SESSION['user'] = $conn;
    // var_dump($_SESSION['user']);
    // die;
    if ($conn) {
        header('location:acceuil.php');
        echo "Connexion effectuée";
    } else {
        echo "Aucun utilisateur trouvé avec cet email et mot de passe.";
    }
}



?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>


    <div id="general">


        <div id="niveau">
            <h1 id="ins">Connexion</h1>
            <p id="votre">Votre chauffeur en un clic</p>

            <div id="facebook">
                <p id="mess">Continuer avec Facebook</p><br>
            </div>
            <br>
            <br>
            <div style="text-align: center;">
                <hr style="display: inline-block; width: 40%;">
                <span style="padding: 0 10px;">ou</span>
                <hr style="display: inline-block; width: 40%;">
            </div>
            <br>


            <form action="" method="post">
                <div>
                    <label for="">Email</label>
                    <input class="tel" type="text" name="mail" placeholder="Entrer votre email" value="<?php if (!empty($erreursConn)) echo $_POST['mail'] ?> ">
                </div>

                <div>
                    <br>
                    <label for="">Mot de Passe</label>
                    <input class="tel" type="text" name="pass" placeholder="********" value="<?php if (!empty($erreursConn)) echo $passe ?>"><br>
                    <br>
                    <input id="ins1" type="submit" name="connexion" value="Se connecter ->"><br>
                    <br>
                </div>
            </form>
            <br>

            <a href="">J'ai pas encore de compte</a>
        </div>



        <div id="div1">
            <h1 id="bien">Inscription</h1>
            <p id="message">Finaliser votre inscription en renseignant les informations manquantes</p><br>

            <form action="" method="post">

                <div id="div2">

                    <div>

                        <label for="">PRENOM</label>
                        <input id="pre" type="text" name="prenom" placeholder="Entrez votre prénom" value="<?php if (!empty($erreursIns)) echo $prenom ?>">

                    </div>
                    <div>
                        <label for="">NOM</label>
                        <input id="nom" type="text" name="nom" placeholder="Entrez votre nom" value="<?php if (!empty($erreursIns)) echo $nom ?>">

                    </div>

                </div>
                <br>


                <div>
                    <label for="">TELEPHONE</label>
                    <!-- <img src="C:\xampp\htdocs\taxiBokko\photo" alt="drapeau"> -->
                    <!-- <span class="indicatif">+221</span> -->
                    <input class="tel" type="text" name="tel" placeholder="+221 70 000 00 00" value="<?php if (!empty($erreursIns)) echo $telephone ?>">
                    <br>
                </div>

                <div>
                    <label for="">Email</label>
                    <input class="tel" type="text" name="email" placeholder="Entrer votre email" value="<?php if (!empty($erreursIns)) echo $mail ?>">
                </div>

                <div>
                    <br>
                    <label for="">Mot de Passe</label>
                    <input class="tel" type="text" name="passe" placeholder="********" value="<?php if (!empty($erreursIns)) echo $pass ?>"><br>
                    <br>

                </div>

                <p id="promo">Ajouter un code promo</p><br>
                <input id="ins2" type="submit" name="inscription" value="S'inscrire ->">

            </form>
            <br>

            <a href="" id="lien">J'ai déjà un compte</a>

        </div>

    </div>


    <br><br><br><br><br>

   


</body>

</html>