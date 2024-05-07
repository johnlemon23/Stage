<?php
require_once 'ModelManager.class.php';
require_once 'Commune.class.php';
class CommuneManager extends ModelManager 
{
  public function getCommunes($codepostal)
  {
      $sql = "SELECT ville_nom_reel
              FROM villes_france_free 
              WHERE ville_code_postal = :codepostal";
      $params = array(':codepostal' => $codepostal);
      $result = $this->executerRequete($sql, $params);
      $communes = array();
      while ($row = $result->fetch()) {
        $communes[] = $row["ville_nom_reel"];
      }

      $communes_str = implode(',', $communes);
      echo($communes_str);
  }
}