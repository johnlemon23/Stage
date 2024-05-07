<?php
$titre ="Inscription activité";
ob_start();
?>
        <form action="formAct.php" method="post">
            <img src="Asset/LOGO-CS.png" alt="logo du centre les passerelles">
            <p>Sauf activité exceptionnelle ou manifestation publique, l'adhésion est obligatoire pour participer aux activités du Centre Socioculturel.</p>
            <p>Vous pouvez adhérer en remplisant le formulaire complet sur ce boutton <a href="index.php"><button type="button">📝Formulaire d'inscription</button></a>
            <p>Adhésion du 1er septembre ou de la date d'adhésion au 31 août de l'année.</p>
            <h3>Activité :</h3>
            <div id="ChoixActivite" class="grid">
                <select id="activite" name="activite">
                    <option value="">-- choisissez une activité --</option>
                    <?php
                    $controller = new Controller();
                    $controller->listeact();
                    ?>
                </select><span style="color: red;">*</span>
            </div>
            <h2>Renseignements:</h2>
            <label>Nombre de personnes dans le foyer :
            <input type="number" id="nombre_adherent" name="nombre_adherent" min="1" max="10" onchange="ajouterForm()">-Indiquer l'ensemble des prénoms, dates de naissance et noms ci-dessous</label>
            <div class="flex">
                <div id="form-repete" class="container">
                    <div class="nom">
                        <input type="text" name="nom[]" placeholder="Nom" required="required"><span style="color: red;">*</span>
                    </div>
                    <div class="prenom">
                        <input type="text" name="prenom[]" placeholder="Prénom" required="required"><span style="color: red;">*</span>
                    </div>
                    <div class="naissance">
                        <label for="statut">Date de naissance<span style="color: red;">*</span> :</label>
                        <input type="date" name="naissance[]" required="required">
                    </div>
                </div>
                <div id="lieu" class="container">
                    <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" required="required"><span style="color: red;">*</span>
                    <select id="commune" name="user_commune">
                        <option value="">-- choisissez une commune --</option>
                    </select><span style="color: red;">*</span>
                </div>
            </div>
            <input type="submit" name="envoi">
        </form>
<?php
$content = ob_get_clean();
require "Layouts/gabarit.php";