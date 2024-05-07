<?php


class Controller {
        
        function formulaireAdhesion()
        {
                require_once("Views/formulaire_adhesion.php");
                require_once("ajax.php");
                
        }

        function AdhesionComplete()
        {
                require_once("Views/formulaire_adhesion_complete.php");
        }
        
        function inscriptionActivite()
        {
                require_once("Views/inscription_activite.php");
        }

        public function listeact() {
                require_once ("Models/ActiviteManager.class.php");
                
                $model = new ActiviteManager("cs-les-passerelles_bdd_adherent");
                $data = $model->getActivites();
                foreach($data as $value){
                        echo('<option value="'.$value.'">'.$value.'</option>$value)');
                }
                
        }
}