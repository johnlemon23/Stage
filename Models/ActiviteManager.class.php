<?php
require_once 'ModelManager.class.php';
class ActiviteManager extends ModelManager
{
  public function getActivites()
  {
      $sql = "SELECT libelle
              FROM activite";
      $params = null;
      $result = $this->executerRequete($sql, $params);
      $activites = array();
      while ($row = $result->fetch()) {
        $activites[] = $row["libelle"];
      }
      return($activites);
  }
}