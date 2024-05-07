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
    $tel_1 = $_POST["tel_1"];
    $tel_2 = $_POST["tel_2"];
    $e_mail_1 = $_POST["e-mail_1"];
    $e_mail_2 = $_POST["e-mail_2"];
    $e_mail_3 = $_POST["e-mail_3"];

    if($refus_info===true){
        $refus_info="checked";
    }
    else{
        $refus_info="";
    }

    $nombre_adherent=$_POST["nombre_adherent"];
    $numero_police = $_POST["numero_police"];
    
    $bdd=null;

    /*##########Script Information#########
    # Purpose: Send mail Using PHPMailer  #
    #          & Gmail SMTP Server 	      #
    # Created: 28-06-2023 			      #
    #	Author : TISNE Marc			      #
    # Version: 1.0					      #
    #####################################*/

    //Include required PHPMailer files
        include('includes/PHPMailer.php');
        include('includes/SMTP.php');
        include('includes/Exception.php');

    //Create instance of PHPMailer
        $mail = new PHPMailer();
    //Set mailer to use smtp
        $mail->isSMTP();
    //Define smtp host
        $mail->Host = "smtp.gmail.com";
    //Enable smtp authentication
        $mail->SMTPAuth = true;
    //Set smtp encryption type (ssl/tls)
        $mail->SMTPSecure = "tls";
    //Port to connect smtp
        $mail->Port = "587";
    //Set gmail username
        $mail->Username = "lespasserelles11@gmail.com";
    //Set gmail password
        $mail->Password = "hakzmavmosckbmxu";
    //Email subject
        $mail->Subject = utf8_decode("Adhesion d'un adherent en ligne");
    //Set sender email
        $mail->setFrom('lespasserelles11@gmail.com');
    //Enable HTML
        $mail->isHTML(true);
    //Email body
        $mail->Body = utf8_decode("<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<title>Formulaire d'adhésion</title>
</head>
<body>
<main>
<form action='form.php' method='post'>
    <h1>Fiche d'adhésion 2023/2024</h1>
    <p>Sauf activité exceptionnelle ou manifestation publique, l'adhésion est obligatoire pour participer aux activités du Centre Socioculturel. Adhésion du 1er septembre de l'année (n) ou de la date d'adhésion au 31 août de l'année (n+1). Individuelle (5 euros) ou Familiale (10 euros): Adhésion familiale réservée aux parents directs (familles recomposées incluses)</p>
    <h2>Renseignements:</h2>
    <label>Nombre de personnes dans le foyer :&nbsp;</label>
    <p style='height: 25px; margin-bottom: 10px;'><span style='font-weight: bold;'>$nombre_adherent</span> -Indiquer l'ensemble des noms, prénoms et dates de naissance ci-dessous</p>
    <div class='flex'>
        <table class='table-style' style='border-collapse: collapse;box-shadow: 0 5px 50px rgba(0,0,0,0.15);border: 2px solid #b5b5b5;width: 100%;'>
            <thead style='background-color: #b5b5b5;color: #fff;text-align: left;'>
                <tr>
                    <th style='width:6cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Nom</th>
                    <th style='width:6cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Prénom</th>
                    <th style='width:3cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Date de naissance</th>
                    <th style='width:2.5cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Filiation (Père, Mère, Enfant, Autre... )</th>
                </tr>
            </thead>
            <tbody>
                <tr style='border: 1px solid #ddd;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[0]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[0]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[0]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[0]</td>
                </tr>
                <tr style='border: 1px solid #ddd;background-color: #f3f3f3;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[1]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[1]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[1]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[1]</td>
                </tr>
                <tr style='border: 1px solid #ddd;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[2]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[2]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[2]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[2]</td>
                </tr>
                <tr style='border: 1px solid #ddd;background-color: #f3f3f3;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[3]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[3]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[3]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[3]</td>
                </tr>
                <tr style='border: 1px solid #ddd;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[4]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[4]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[4]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[4]</td>
                </tr>
                <tr style='border: 1px solid #ddd;background-color: #f3f3f3;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[5]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[5]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[5]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[5]</td>
                </tr>
                <tr style='border: 1px solid #ddd;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[6]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[6]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[6]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[6]</td>
                </tr>
                <tr style='border: 1px solid #ddd;background-color: #f3f3f3;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[7]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[7]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[7]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[7]</td>
                </tr>
                <tr style='border: 1px solid #ddd;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[8]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[8]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[8]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[8]</td>
                </tr>
                <tr style='border: 1px solid #ddd;background-color: #f3f3f3;min-height: 0px;'>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$nom_adherent[9]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$prenom_adherent[9]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$date_naissance[9]</td>
                    <td style='text-align: center;height:auto;border: 1px solid #ddd;'>$filiation[9]</td>
                </tr>
            </tbody>
        </table>
        <div id='statut' class='flex' style='padding:1em;'>
            <label>Statut: <span style='font-weight: bold;'>$statut</span></label>
        </div>
    </div>
    <h2>Lieux :</h2>
    <div id='lieu' class='grid'>
        <table class='table-style' style='border-collapse: collapse;box-shadow: 0 5px 50px rgba(0,0,0,0.15);border: 2px solid #b5b5b5;width: 100%;'>
            <thead  style='background-color: #b5b5b5;color: #fff;text-align: left;'>
                <tr>
                    <th style='width:12cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Adresse</th>
                    <th style='width:3cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Commune</th>
                    <th style='width:2.5cm;text-align: center;height: 2.25em;border: 1px solid #ddd;'>Code postal</th>
                </tr>
            </thead>
            <tbody>
                <tr style='border: 1px solid #ddd;'>
                    <td style='text-align: center;height: 2.25em;border: 1px solid #ddd;'>$adresse</td>
                    <td style='text-align: center;height: 2.25em;border: 1px solid #ddd;'>$commune</td>
                    <td style='text-align: center;height: 2.25em;border: 1px solid #ddd;'>$code_postal</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id='Assurance'>
        <h2>Assurance :</h2>
        <p>La souscription à une police d'assurance 'responsabilité civile' est obligatoire pour l'accès à nos activités. Le centre se réserve le droit de poursuivre les fausses déclarations.</p>
        <div id='Assurance' class='grid'>
            <label>Nom de l'assurance :</label>
            <span style='font-weight: bold;'>$nom_assurance</span>
            <label>Numéro police assurance :</label>
            <span style='font-weight: bold;'>$numero_police</span>
        </div>
    </div>
    <div id='information'>
        <h2>Information / mail</h2>
        <div class='grid'>
            <label for='tel'>Numéro(s) de téléphone :</label>
            <span style='font-weight: bold;'>$tel_1</span>
            <span style='font-weight: bold;'>$tel_2</span>
            <label for='e-mail'>Adresse(s) e-mail :</label>
            <span style='font-weight: bold;'>$e_mail_1</span>
            <span style='font-weight: bold;'>$e_mail_2</span>
            <span style='font-weight: bold;'>$e_mail_3</span>
        </div>
        <p>Les Passerelles proposent de vous tenir informé(s) par mail 1 à 2 fois par mois des activités, projets, etc...</p>
        <div class='checkbox'>
            <input type='checkbox' id='refus_info' name='refus_info' style='top:10px;' $refus_info disabled>
            <label for='refus_info'>Non je refuse cette proposition.</label>
        </div>
    </div>
    <div id='mentions'>
        <h2 style='position:absolute; top:745px; left: 300px;'>Mentions importantes</h2>
        <p>Droit à l'image: le centre utilise les images de ses adhérents dans ses publications (photos, presses, facebook, site internet...). Vous vous opposez à l'utilisation de votre image ? Il faut noter de manière manuscrite ci-dessous :<span style='font-weight: bold;'>$refus_droit_image</span></p>
        <p>Par sa signature ci-dessous, l'adhérent reconnaît avoir pris connaissance du règlement intérieur et s'y conformer. La souscription à une police d'assurance 'responsabilité civile' est obligatoire pour l'accès à nos activités. Le centre se réserve le droit de poursuivre les fausses déclarations. Les informations recueillies sont traitées dans un fichier informatique.</p>
        <h4>
            <input type='checkbox' name='droit_donnee_caractere_personnel' id='droit_dcp' class='check' checked disabled>
            En cochant cette case et en soumettant ce formulaire, je m'oppose à l'utilisation de mes données personnelles et m'oppose à être recontacté(e) dans le cadre de ma demande indiqué(e) dans ce formulaire. Aucun traitement ne sera effectué avec mes informations. Conformément à la Loi informatique et Libertés, vous disposez d'un droit d'accès, de rectification et d'opposition aux données vous concernant, que vous pouvez exercer en adressant une demande par courrier à l'adresse postale indiquée dans le paragraphe en pied de page.
        </h4>
        <p style='float: right; margin-right: 200px;'>Signature : </p>
    </div>
</form>
</main>
</body>
</html>");
    //Add recipient
        $mail->addAddress('accueil@cs-les-passerelles.fr');
    //Finally send email
        if ( $mail->send() ) {
            echo "<h2>Email envoyé !</h2>";
        }else{
            echo "Le message ne s'est pas envoyé. Mail Erreur: ".$mail->ErrorInfo;
        }
    //Closing smtp connection
        $mail->smtpClose();

}

?>