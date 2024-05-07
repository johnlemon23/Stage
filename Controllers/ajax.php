<?php

Class Ajax {
    public function listecomm($codepostal) {
        require_once ("../Models/CommuneManager.class.php");
        
        $model = new CommuneManager("cs-les-passerelles_bdd_commune");
        $data = $model->getCommunes($codepostal);
        
    }
}

if (isset($_POST['code_postal'])) {
    $codePostal = $_POST['code_postal'];

    $ajax = new Ajax();
    $ajax->listecomm($codePostal);
}