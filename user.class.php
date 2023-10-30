<?php

class Utilisateur
{
    private $nom;
    private $prenom;
    private $telephone;
    private $email;
    private $pass;


    public function __construct($nom, $prenom, $telephone, $email, $pass)
    {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setTelephone($telephone);
        $this->setEmail($email);
        $this->setPass($pass);
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setNom($newNom)
    {
        if (empty($newNom) || !preg_match("/^[a-zA-Z]+$/", $newNom)) {
            throw new Exception("Donner un nom correct svp");
        } else {
            $this->nom = $newNom;
        }
    }

    public function setPrenom($newPrenom)
    {
        if (empty($newPrenom) || !preg_match("/^[a-zA-Z ]+$/", $newPrenom)) {
            throw new Exception("Donner un prénom correct svp");
        } else {
            $this->prenom = $newPrenom;
        }
    }

    public function setTelephone($newTelephone)
    {
        if (empty($newTelephone) || !preg_match("/^[0-9]+$/", $newTelephone) || substr($newTelephone, 0, 1) != 7 || strlen($newTelephone) != 9) {
            throw new Exception("Donner un numéro de téléphone correct");
        } else {
            $this->telephone = $newTelephone;
        }
    }


    public function setEmail($newEmail)
    {
        if (empty($newEmail) || !preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,5}$/", $newEmail)) {
            throw new Exception("Donner un email correct");
        } else {
            $this->email = $newEmail;
        }
    }


    public function setPass($newPass)
    {
        if (empty($newPass) || strlen($newPass) !=  8) {
            throw new Exception("Donner un mot de passe de 8 caractères");
        } else {
            $passcrypt = md5($newPass);
            $this->pass = $passcrypt;
        }
    }





    public function inscription($connexion)
    {

        $sql = ("INSERT INTO `users`(`nom`, `prenom`, `telephone`, `email`, `motdepasse`) VALUES (:nom, :prenom, :telephone, :email, :motdepasse)");
        $insertion = $connexion->prepare($sql);
        $insertion->bindParam(':nom', $this->nom);
        $insertion->bindParam(':prenom', $this->prenom);
        $insertion->bindParam(':telephone', $this->telephone);
        $insertion->bindParam(':email', $this->email);
        $insertion->bindParam(':motdepasse', $this->pass);

        $insertion->execute();

        return "Inscription effectuée";
    }


    public static function seConnecter($mail, $pass, $connexion)
    {
        if (empty($mail) || empty($pass)) {
            throw new Exception("Tous les champs sont obligatoires");
        } else {

            if (!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,}$/", $mail)) {
                throw new Exception("Donner un email correct");
            } else {

                $query = "SELECT * FROM `users` WHERE email = :email AND motdepasse = :passe";
                $connecter = $connexion->prepare($query);
                $connecter->bindParam(':email', $mail);
                $connecter->bindParam(':passe', $pass);

                $reu = $connecter->execute();

                if ($reu) {
                    $resutat = $connecter->fetchAll();
                }


                return $resutat;
            }
        }
    }

    public static function listeUser($connexion)
    {
        $sql = "SELECT * FROM `users`";
        $user = $connexion->query($sql);
        if ($user) {
            $result = $user->fetchAll();
        }

        return $result;
    }

    
}
