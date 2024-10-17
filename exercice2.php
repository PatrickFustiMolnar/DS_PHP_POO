<?php

abstract class Vehicule 
{
    protected $demarrer = FALSE;
    protected $vitesse = 0;
    protected $vitesseMax;

    abstract function decelerer($vitesse);
    abstract function accelerer($vitesse);

    public function demarrer() 
    {
        $this->demarrer = TRUE;
    }

    public function eteindre() 
    {
        $this->demarrer = FALSE;
    }

    public function estDemarre() 
    {
        return $this->demarrer;
    }

    public function estEteint() 
    {
        return !$this->demarrer;
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
        $chaine = "Ceci est un véhicule <br/>";
        $chaine .= "---------------------- <br/>";
        return $chaine;
    }
}

class Avion extends Vehicule
{
    private $altitude = 0; // Altitude actuelle
    private $plafond; // Plafond maximum spécifique à l'avion
    private $trainAtterrissage = TRUE; // True si le train est sorti
    private const PLAFOND_MAX = 40000; // Plafond maximal pour tous les avions
    private const VITESSE_MAX = 2000; // Vitesse maximale de tous les avions

    public function __construct($vitesseMax, $plafond)
    {
        // Limiter le plafond et la vitesse max
        $this->vitesseMax = min($vitesseMax, self::VITESSE_MAX);
        $this->plafond = min($plafond, self::PLAFOND_MAX);
    }

    public function decelerer($vitesse)
    {
        if ($this->vitesse - $vitesse >= 0) {
            $this->vitesse -= $vitesse;
        } else {
            $this->vitesse = 0;
        }
    }

    public function accelerer($vitesse)
    {
        if ($this->vitesse + $vitesse <= $this->vitesseMax) {
            $this->vitesse += $vitesse;
        } else {
            $this->vitesse = $this->vitesseMax;
        }
    }

    public function decoller()
    {
        if ($this->vitesse >= 120) {
            $this->altitude = 100; // On atteint une altitude de 100m lors du décollage
            echo "L'avion a décollé à une altitude de 100m.<br/>";
        } else {
            echo "Vitesse insuffisante pour décoller (min 120 km/h).<br/>";
        }
    }

    public function atterrir()
    {
        if ($this->trainAtterrissage && $this->vitesse >= 80 && $this->vitesse <= 110 && $this->altitude >= 50 && $this->altitude <= 150) {
            $this->altitude = 0;
            $this->vitesse = 0;
            echo "L'avion a atterri avec succès.<br/>";
        } else {
            echo "Conditions non remplies pour atterrir (train sorti, vitesse entre 80-110 km/h, altitude entre 50-150m).<br/>";
        }
    }

    public function prendreAltitude($altitude)
    {
        if ($this->altitude > 0) {
            if (!$this->trainAtterrissage || $this->altitude > 300) {
                $nouvelleAltitude = $this->altitude + $altitude;
                if ($nouvelleAltitude <= $this->plafond) {
                    $this->altitude = $nouvelleAltitude;
                    echo "L'avion a pris de l'altitude, nouvelle altitude : $this->altitude m.<br/>";
                } else {
                    echo "Impossible de dépasser le plafond de $this->plafond mètres.<br/>";
                }
            } else {
                echo "Impossible de prendre de l'altitude au-dessus de 300m sans rentrer le train d'atterrissage.<br/>";
            }
        } else {
            echo "L'avion n'a pas encore décollé.<br/>";
        }
    }

    public function perdreAltitude($altitude)
    {
        if ($this->altitude > 0) {
            $nouvelleAltitude = $this->altitude - $altitude;
            if ($nouvelleAltitude >= 0) {
                $this->altitude = $nouvelleAltitude;
                echo "L'avion a perdu de l'altitude, nouvelle altitude : $this->altitude m.<br/>";
            } else {
                $this->altitude = 0;
                echo "L'avion est à une altitude de 0 m.<br/>";
            }
        } else {
            echo "L'avion n'a pas encore décollé.<br/>";
        }
    }

    public function sortirTrainAtterrissage()
    {
        $this->trainAtterrissage = TRUE;
        echo "Le train d'atterrissage est sorti.<br/>";
    }

    public function rentrerTrainAtterrissage()
    {
        if ($this->altitude > 300) {
            $this->trainAtterrissage = FALSE;
            echo "Le train d'atterrissage est rentré.<br/>";
        } else {
            echo "Impossible de rentrer le train d'atterrissage en-dessous de 300m.<br/>";
        }
    }

    public function getAltitude()
    {
        return $this->altitude;
    }

    public function getPlafond()
    {
        return $this->plafond;
    }

    public function estTrainSorti()
    {
        return $this->trainAtterrissage;
    }
}






























// Test de l'implémentation
$avion = new Avion(1500, 35000); // Un avion avec une vitesse max de 1500 km/h et un plafond de 35000 mètres

$avion->demarrer();
$avion->accelerer(130);
$avion->decoller();
$avion->prendreAltitude(500);
$avion->rentrerTrainAtterrissage();
$avion->prendreAltitude(1000);
$avion->sortirTrainAtterrissage();
$avion->decelerer(50);
$avion->atterrir();





?>