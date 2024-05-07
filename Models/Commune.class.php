<?php
class Commune
{
	// Attributs
	private $_nomReel;
	private $_codePostal;
	

	public function __construct($donnees)
	{
		$this->hydrate($donnees);
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method))
			{
				$this->$method($value);
			}
		}
	}

	// Getters

	public function getNomReel()
	{
		return $this->_nomReel;
	}

	public function getCodePostal()
	{
		return $this->_codePostal;
	}
    
	// Setters

	public function setNomReel($nom)
	{
		if (is_string($nom))
		{
			$this->_nomReel = $nom;
		}	
	}

	public function setCodePostal($codePostal)
	{
		$this->_codePostal = $codePostal;
	}
}
?>