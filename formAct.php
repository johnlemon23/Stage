<?php
require("Controllers/controller.php");

$controller = new Controller();
$controller->AdhesionComplete();
if(isset($_POST["envoi"])){

    // Connexion
    require_once("Models/ModelManager.class.php");
    $bdd = new ModelManager("cs-les-passerelles_bdd_adherent");

    // Requete pour recuperer l'ID le plus haut des dossier existants

    $req = "SELECT MAX(id_dossier) as last_dossier FROM dossier";
    $params = null;
    $result = $bdd->executerRequete($req,$params);
    $data = $result->fetch();

    $last_dossier = $data['last_dossier'];

    // Attribution d'un nouvel ID non utilise au dossier actuel
            
    $nouvel_id_dossier = $last_dossier + 1;

    // Insertion des informations de l'assurance

    $req = "SELECT numero_police FROM assurance WHERE EXISTS (SELECT * FROM assurance WHERE numero_police=:numero_police)";

    if(isset($_POST["numero_police"])){
        $numero_police = $_POST["numero_police"];
    }
    else{
        $numero_police = 0;
    }
            
    $params = array(':numero_police' => $numero_police);
    $result = $bdd->executerRequete($req,$params);
            
    $res = $result->fetch();

    if ($res===false){
        $req = "INSERT INTO assurance (numero_police, nom_assurance) VALUES (:numero_police, :nom_assurance)"or die(mysql_error());
        $nom_assurance = $_POST["nom_assurance"];
        $params = array(':numero_police' => $numero_police, ':nom_assurance' => $nom_assurance);
        $result = $bdd->executerRequete($req,$params);
    }

    // Insertion des informations du dossier avec le nouvel ID

    $req = "INSERT INTO dossier (id_dossier, statut, adresse, code_postal, commune, date_dossier, numero_police) VALUES (:id_dossier, :statut, :adresse, :code_postal, :commune, :date_dossier, :numero_police)"or die(mysql_error());

    $statut = $_POST["statut"];
    $adresse = $_POST["user_adresse"];
    $code_postal = $_POST["code_postal"];
    $commune = $_POST["user_commune"];
    $date_dossier = date('Y/m/d');
            
    $params = array(':id_dossier' => $nouvel_id_dossier, ':statut' => $statut, ':adresse' => $adresse, ':code_postal' => $code_postal, ':commune' => $commune, ':date_dossier' => $date_dossier, ':numero_police' => $numero_police);
    $result = $bdd->executerRequete($req,$params);
        
    //inserer un adherent

    // Requete pour recuperer l'ID le plus haut des adherents existants

    $req = "SELECT MAX(id_adherent) as last_adherent FROM adherent";
    $params = null;
    $result = $bdd->executerRequete($req,$params);
    $data = $result->fetch();
    $last_adherent = $data['last_adherent'];

    // Attribution d'un nouvel ID non utilise a l'adherent actuel

    $nouvel_id_adherent = $last_adherent + 1;

    // Insertion des donnees pour chaque adherent du dossier    

    $req="INSERT INTO adherent (id_adherent,nom_adherent,prenom_adherent,date_naissance,filiation,id_dossier) VALUES (:id_adherent,:nom,:prenom,:date_naissance,:filiation,:id_dossier)";

    $nom_adherent = $_POST["nom"];
    $prenom_adherent = $_POST["prenom"];
    $date_naissance = $_POST["naissance"];
    $filiation = $_POST["filiation"];

    for ($i = 0; $i < count($nom_adherent); $i++) {
        $params = array(':id_adherent'=> $nouvel_id_adherent,':nom'=> $nom_adherent[$i],':prenom'=> $prenom_adherent[$i],':date_naissance'=> $date_naissance[$i],':filiation'=> $filiation[$i],':id_dossier'=> $nouvel_id_dossier);
        $result = $bdd->executerRequete($req,$params);
        $nouvel_id_adherent = $nouvel_id_adherent + 1;
    }
    //inserer les contacts

    // Requete pour recuperer l'ID le plus haut des contacts existants

    $req = "SELECT MAX(id_contact) as last_contact FROM contact";
    $params = null;
    $result = $bdd->executerRequete($req,$params);
    $data = $result->fetch();
    $last_contact = $data['last_contact'];

    // Attribution d'un nouvel ID non utilise au contact actuel

    $nouvel_id_contact = $last_contact + 1;
    $req="INSERT INTO contact (id_contact,tel,e_mail,refus_info,id_dossier) VALUES (:id_contact,:tel,:e_mail,:refus_info,:id_dossier)";
    $tel = $_POST["tel_1"];
    $e_mail = $_POST["e-mail_1"];
    $refus_info = isset($_POST["refus_info"]);
    $params = array(':id_contact' => $nouvel_id_contact,':tel' => $tel,':e_mail' => $e_mail,':refus_info' => $refus_info,':id_dossier' => $nouvel_id_dossier);
    $result = $bdd->executerRequete($req,$params);
    
    if ($_POST["tel_2"]!=null or $_POST["e-mail_2"]!=null){
        
        $nouvel_id_contact = $nouvel_id_contact +1;
        $tel = $_POST["tel_2"];
        $e_mail = $_POST["e-mail_2"];
        $params = array(':id_contact' => $nouvel_id_contact,':tel' => $tel,':e_mail' => $e_mail,':refus_info' => $refus_info,':id_dossier' => $nouvel_id_dossier);
        $result = $bdd->executerRequete($req,$params);
    }
    
    if ($_POST["tel_3"]!=null or $_POST["e-mail_3"]!=null){
        $nouvel_id_contact = $nouvel_id_contact +1;
        $tel = $_POST["tel_3"];
        $e_mail = $_POST["e-mail_3"];
        $params = array(':id_contact' => $nouvel_id_contact,':tel' => $tel,':e_mail' => $e_mail,':refus_info' => $refus_info,':id_dossier' => $nouvel_id_dossier);
        $result = $bdd->executerRequete($req,$params);
    }
    $bdd=null;
    exit;
}

?>