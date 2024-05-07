<?php
class ModelManager {
    private $bdd;
    function __construct($dbname){
        $dsn = "mysql:host=mysql-cs-les-passerelles.alwaysdata.net;port=3306;dbname=$dbname";
        $user = "342621";
        $pass = "defrocourt11120";
        try {
            $this->bdd = new PDO ($dsn,$user,$pass);
        }
        catch(PDOException $e) {
            $errorMessage = date('l jS \of F Y h:i:s A ');
            $errorMessage .= " Le code erreur est : ".$e->getCode();
            $errorMessage .= " Le message : ".$e->getMessage();
            $errorMessage .= " Le fichier : ".$e->getFile();
            $errorMessage .= "\n";
            // Chemin du fichier log
            $logFile = "logs/errors.log";
            // Chemin du fichier accès non autorisé 
            $logFileAccess = "logs/access.log";
            // Enregistrement du message d'erreur dans le fichier log
            error_log($errorMessage, 3, $logFile);
            if ($e->getCode() == 1045)
            {
                error_log($errorMessage, 3, $logFileAccess);
            }
            $this->bdd = null;
        }
    }

    public function executerRequete($sql, $params) {
        if ( $this->bdd != null) {
            if ($params == null ) {
                $resultat = $this->bdd->query($sql);
            }
            else {
                $resultat = $this->bdd->prepare($sql);
                $resultat->execute($params);
            }
            return $resultat;
        }
        else
            return false;
     }
}