<?php
class Connexion {

/*
// attributs de la classe Connexion paramètres de connexion à la base
static private $hostname = 'localhost';
static private $database = 'marmiuton';
static private $login = 'marmiuton';
static private $password = 's6rqTiA0hNKmcgy7';
*/

// attribut de la classe Connexion paramètres d'encodage
static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

// attribut de la classe Connexion qui recevra l'instance PDO
static private $pdo;

// getter de pdo
static public function pdo() {return self::$pdo;}

// fonction de connexion
static public function connect()  {
    require "core/conf/ConfigurationGenerale.php"; // Ce fichier contient les identifiants
    $h = $bddHost;
    $d = $bddName;
    $l = $bddUsername;
    $p = $bddUserPassword;
    $t = self::$tabUTF8;
    try {
        self::$pdo = new PDO("mysql:host=$h;dbname=$d",$l,$p,$t);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Erreur de connexion !";
    }
  }
}