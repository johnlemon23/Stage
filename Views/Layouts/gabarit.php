<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf8">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="jumbo"></div>
    <nav>
        <ul class="nav-list">
            <img src="Asset/LOGO-CS-removebg-preview.png" alt="logo du centre les passerelles">
            <li>
                <a href="https://www.cs-les-passerelles.fr/accueil">Accueil</a>
            </li>
            <li>
                <a href="https://www.cs-les-passerelles.fr/actualité">Actualité</a>
            </li>
            <li>
                <a href="#" class="deroulant">Les Pôles</a>
                <ul class="sous">
                    <li><a href="https://www.cs-les-passerelles.fr/pôles/pôle-accueil">Pôle Accueil</a></li>
                    <li><a href="https://www.cs-les-passerelles.fr/pôles/pôle-animation">Pôle Animation</a></li>
                    <li><a href="https://www.cs-les-passerelles.fr/pôles/pôle-coordination-globale">Pôle Coordination Globale</a></li>
                    <li><a href="https://www.cs-les-passerelles.fr/pôles/pôle-famille">Pôle Famille</a></li>
                </ul>
            </li>
            <li>
                <a href="https://cs-les-passerelles.alwaysdata.net/">Formulaire d'adhésion</a>
            </li>
        </ul>
    </nav>
    <main>
        <h1><?= $titre ?></h1>
        <?= $content ?>
    </main>
    <aside>
        <h2 class="deroulant">Nous Contacter</h2>
            <ul class="sous">
                <li><span class="gras">Tel:</span> 04 30 16 67 15</li>
                <li><span class="gras">Mail:</span> lespasserelles@cs-les-passerelles.fr</li>
                <li><span class="gras">Adresse:</span> 107 avenue de Saint-Pons</li>
                <li>11120 Saint-Marcel-sur-Aude</li>
            </ul>
    </aside>
</body>
<script src="script.js"></script>
</html>