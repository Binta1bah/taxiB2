<?php

class Database
{
    private $localhost;
    private $db;
    private $user;
    private $passe;
    private $connexion;

    public function __construct($localhoste, $db, $user, $passe)
    {
        $this->localhost = $localhoste;
        $this->db = $db;
        $this->user = $user;
        $this->passe = $passe;

        //$this->connect();
    }

    public function connect()
    {
        try {
            $ser = "mysql:host=$this->localhost;dbname=$this->db";
            $connexion = new PDO($ser, $this->user, $this->passe);
            return $connexion;
        } catch (PDOException $e) {

            die("La connexion à la base de données n'a pas reussi" . $e->getMessage());
        }
    }

    // public function getConnexion()
    // {
    //     return $this->connexion;
    // }
}
