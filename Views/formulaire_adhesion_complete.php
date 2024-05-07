<?php
$titre ="Merci de votre inscription";
ob_start();
?>
<section>
    <p>Votre demande a bien ete envoyée. Nous vous contacterons dans les plus brefs délais pour confirmer votre inscription.</p>
    <p>En attendant, vous pouvez consulter notre <a href="https://www.cs-les-passerelles.fr/">site web</a> pour en savoir plus sur nos services.</p>
    <a href="index.php">
        <button>⬅️ Retour à l'inscription</button>
    </a>
</section>

<?php
$content = ob_get_clean();
require "Layouts/gabarit.php";