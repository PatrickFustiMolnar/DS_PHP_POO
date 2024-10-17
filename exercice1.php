<?php

abstract class Vehicule 
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;
    protected $freinParking = FALSE;

    
    abstract function demarrer();
    abstract function eteindre();
    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);
    abstract function activerFreinParking();
    abstract function desactiverFreinParking();

    // Méthode magique toString
    public function __toString()
    {
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Voiture extends Vehicule 
{
    const VITESSE_MAX = 360;
    private static $_compteur = 0;

    public static function getNombreVoiture()
    {
        return self::$_compteur;
    }

    public function __construct($vMax) 
    {
        $this->setVitesseMax($vMax);
        self::$_compteur++;
    }

    public function demarrer() 
    {
        if ($this->freinParking) {
            trigger_error("Impossible de démarrer : le frein de parking est activé !", E_USER_WARNING);
        } else {
            $this->demarrer = TRUE;
        }
    }

    public function eteindre() 
    {
        $this->demarrer = FALSE;
    }

    public function estDemarre() 
    {
        return $this->demarrer;
    }

    public function accelerer($vitesse) 
    {
        if ($this->estDemarre() && !$this->freinParking) 
        {
            if ($this->vitesse == 0) 
            {
                // Exception quand la voiture est à l'arrêt
                $vitesseMaxPossible = 10;
            } 
            else 
            {
                // On ne peut pas dépasser 30% de la vitesse actuelle
                $vitesseMaxPossible = $this->vitesse * 1.3;
            }

            $vitesseCible = min($this->vitesse + $vitesse, $vitesseMaxPossible);
            $this->setVitesse($vitesseCible);
        } 
        else if ($this->freinParking)
        {
            trigger_error("Impossible d'accélérer : le frein de parking est activé !", E_USER_WARNING);
        }
        else 
        {
            trigger_error("On ne peut pas accélérer ! Le moteur est à l'arrêt !", E_USER_WARNING);
        }
    }

    public function decelerer($vitesse) 
    {
        if ($this->estDemarre()) 
        {
            // On ne peut pas décélérer de plus de 20 km/h en une fois
            $vitesseCible = max($this->vitesse - min($vitesse, 20), 0);
            $this->setVitesse($vitesseCible);
        }
    }

    public function activerFreinParking()
    {
        if ($this->vitesse == 0) 
        {
            $this->freinParking = TRUE;
        } 
        else 
        {
            trigger_error("Le frein de parking ne peut être activé que lorsque la voiture est à l'arrêt.", E_USER_WARNING);
        }
    }

    public function desactiverFreinParking()
    {
        $this->freinParking = FALSE;
    }

    public function setVitesseMax($vMax) 
    {
        if ($vMax > self::VITESSE_MAX) 
        {
            $this->vitesseMax = self::VITESSE_MAX;
        } 
        elseif ($vMax > 0) 
        {
            $this->vitesseMax = $vMax;
        } 
        else 
        {
            $this->vitesseMax = 0;
        }
    }

    public function setVitesse($vitesse) 
    {
        if ($vitesse > $this->getVitesseMax()) 
        {
            $this->vitesse = $this->getVitesseMax();
        } 
        elseif ($vitesse > 0) 
        {
            $this->vitesse = $vitesse;
        } 
        else 
        {
            $this->vitesse = 0;
        }
    }

    public function getVitesse() 
    {
        return $this->vitesse;
    }

    public function getVitesseMax() 
    {
        return $this->vitesseMax;
    }

    public function __toString() 
    {
        $chaine = parent::__toString();
        $chaine .= "La voiture a une vitesse maximale de " . $this->vitesseMax . " km/h <br/>";
        if ($this->demarrer) 
        {
            $chaine .= "Elle est démarrée <br/>";
            $chaine .= "Sa vitesse est actuellement de " . $this->getVitesse() . " km/h <br/>";
        } 
        else 
        {
            $chaine .= "Elle est arrêtée <br/>";
        }
        
        if ($this->freinParking) 
        {
            $chaine .= "Le frein de parking est activé <br/>";
        }
        
        return $chaine;
    }
}



















// Test 1 : Frein de park
$vehicule1 = new Voiture(110);
$vehicule1->activerFreinParking();
$vehicule1->demarrer(); // Doit déclencher une erreur

$vehicule1->desactiverFreinParking();
$vehicule1->demarrer(); // Doit fonctionner

// Test 2 : Limite d'accélération à 30%
$vehicule1->accelerer(40); // De 0 à 10 km/h (car à l'arrêt)
$vehicule1->accelerer(40); // De 10 à 13 km/h (+30%)
$vehicule1->accelerer(12); // De 13 à 16.9 km/h (+30%)
echo $vehicule1;

// Test 3 : Limite de décélération à 20 km/h
$vehicule1->decelerer(50); // Décélération max de 20 km/h
echo $vehicule1;

// Test 4 : Le frein de park activé qiu empêche d'accélérer
$vehicule1->activerFreinParking();
$vehicule1->accelerer(10); // Doit déclencher une erreur

$vehicule2 = new Voiture(180);
echo $vehicule2;

echo "############################ <br/>";
echo "Nombre de voiture instanciée : " . Voiture::getNombreVoiture() . "<br/>";



?> 