<?php
$titre ="Formulaire d'adhésion";
ob_start();
?>
    <form action="form.php" method="post">
        <img src="Asset/LOGO-CS.png" alt="logo du centre les passerelles">
        <p>Sauf activité exceptionnelle ou manifestation publique, l'adhésion est obligatoire pour participer aux activités du Centre Socioculturel.</p>
        <p>Adhésion du 1er septembre ou de la date d'adhésion au 31 août de l'année.</p>
        <p>Individuelle (5€) ou Familiale (10€): Adhésion familiale réservée aux parents directs (familles recomposées incluses)</p>
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
                <div class="filliation">
                    <label for="filiation">Filiation<span style="color: red;">*</span> :</label>
                    <select name="filiation[]" required="required">
                        <option value="">-- choisissez une filiation --</option>
                        <option value="mere">Mère</option>
                        <option value="pere">Père</option>
                        <option value="enfant">Enfant</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
            </div>
        </div>
        <h3>Lieux :</h3>
        <div id="lieu" class="grid">
            <input type="text" id="adresse" name="user_adresse" placeholder="Adresse" required="required"><span style="color: red;">*</span>
            <input type="text" id="code_postal" name="code_postal" placeholder="Code postal" required="required"><span style="color: red;">*</span>
            <select id="commune" name="user_commune">
                <option value="">-- choisissez une commune --</option>
            </select><span style="color: red;">*</span>
        </div>
        <div id="Statut">
            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required="required"><span style="color: red;">*</span>
                <option value="">-- choisissez un statut --</option>
                <option value="retraité">Retraité</option>
                <option value="salarié">Salarié</option>
                <option value="demandeur d'emploi">Demandeur d'emploi</option>
                <option value="étudiant">étudiant</option>
                <option value="autre">Autre</option>
            </select>
            <h2>Assurance :</h2>
            <p>La souscription à une police d'assurance "responsabilité civile" est obligatoire pour l'accès à nos activités.</p>
            <p>Le centre se réserve le droit de poursuivre les fausses déclarations.</p>
            <div id="Assurance" class="grid">
                <input type="text" id="nom_assurance" name="nom_assurance" placeholder="Nom de l'assurance" required="required"><span style="color: red;">*</span>
                <input type="text" id="numero_police" name="numero_police" placeholder="Numéro police assurance">
            </div>
        </div>
        <div id="information">
            <h2>Information / mail</h2>
            <div>
                <label for="tel">Numéro(s) de téléphone :</label>
                <input type="tel" id="tel_1" name="tel_1" required="required" onchange="ajoutInput('tel_1','tel_2')"><span style="color: red;">*</span>
                <input type="tel" id="tel_2" name="tel_2" onchange="ajoutInput('tel_2','tel_3')">
                <input type="tel" id="tel_3" name="tel_3">
            </div>
            <div>
                <label for="e-mail">Adresse(s) email:</label>
                <input type="email" id="e-mail_1" name="e-mail_1" required="required" onchange="ajoutInput('e-mail_1','e-mail_2')"><span style="color: red;">*</span>
                <input type="email" id="e-mail_2" name="e-mail_2" onchange="ajoutInput('e-mail_2','e-mail_3')">
                <input type="email" id="e-mail_3" name="e-mail_3">
                </div>
            <p>Les Passerelles proposent de vous tenir informé(s) par mail 1 à 2 fois par mois des activités, projets, etc...</p>
            <div class="checkbox">
                <input type="checkbox" id="refus_info" name="refus_info">
                <label for="refus_info">Non, je refuse cette proposition.</label>
            </div>
        </div>
        <div id="mentions">
            <h2>Mentions importantes</h2>
            <p>Droit à l'image: le centre utilise les images de ses adhérents dans ses publications (photos, presses, facebook,site internet ...).</p>
            <label for="refus_droit_image">Vous vous opposez à l'utilisation de votre image ? Il faut noter de manière numérique ci-dessous :</label>
            <textarea id="refus_droit_image" name="refus_droit_image" placeholder="Manifestez votre opposition"></textarea>
            <p>Par sa signature ci-dessous, l'adhérent reconnaît avoir pris connaissance du règlement intérieur et s'y conformer.</p>
            <p>La souscription à une police d'assurance "responsabilité civile" est obligatoire pour l'accès à nos activités. Le centre se réserve le droit de poursuivre les fausses déclarations.</p>
            <p>Les informations recueillies sont traitées dans un fichier informatique.</p>
            <h4>
                <input type="checkbox" name="droit_donnee_caractere_personnel" id="droit_dcp" class="check" required="required"><span style="color: red;">*</span>
                En cochant cette case et en soumettant ce formulaire, je m'oppose à l'utilisation de mes données personnelles et m'oppose à être recontacté(e) dans le cadre de ma demande indiqué(e) dans ce formulaire. Aucun traitement ne sera effectué avec mes informations. Conformément à la Loi informatique et Libertés, vous disposez d'un droit d'accès, de rectification et d'opposition aux données vous concernant, que vous pouvez exercer en adressant une demande par courrier à l'adresse postale indiquée dans le paragraphe en pied de page.
            </h4>
        </div>
        <input type="submit" name="envoi">
    </form>
<?php
$content = ob_get_clean();
require "Layouts/gabarit.php";