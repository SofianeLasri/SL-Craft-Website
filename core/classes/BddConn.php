<?php
class BddConn {
    // Attribut de la classe BddConn paramètres d'encodage
    static private array $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    // Attribut de la classe BddConn qui recevra l'instance PDO
    static private PDO $pdoDriver;

    // Getter de pdo
    static public function getPdo(): PDO {
        return self::$pdoDriver;
    }

    // Fonction de connexion
    static public function connect() {
        // On vérifie si l'instance PDO est déjà créée
        if(!isset(self::$pdoDriver)) {
            // On crée une instance de PDO
            // On récupère le fichier de configuration
            require 'configuration.php';
            // On récupère les paramètres de connexion
            $hostName = $config['db']['hostName'];
            $databaseName = $config['db']['databaseName'];
            $userName = $config['db']['userName'];
            $userPassword = $config['db']['userPassword'];

            $options = self::$tabUTF8;
            try {
                self::$pdoDriver = new PDO("mysql:host=$hostName;dbname=$databaseName",$userName,$userPassword,$options);
                self::$pdoDriver->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $error) {
                echo "Erreur de connexion : " . $error->getMessage();
            }

        }
    }
}