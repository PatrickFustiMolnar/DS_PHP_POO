<?php

class Avion {
    private $id;
    private $nom;
    private $paysOrigine;
    private $anneeMiseEnService;
    private $constructeur;

    // Constructeur
    public function __construct($nom = '', $paysOrigine = '', $anneeMiseEnService = 0, $constructeur = '') {
        $this->nom = $nom;
        $this->paysOrigine = $paysOrigine;
        $this->anneeMiseEnService = $anneeMiseEnService;
        $this->constructeur = $constructeur;
    }

    // Hydrater l'objet avec les données d'un tableau associatif
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPaysOrigine() {
        return $this->paysOrigine;
    }

    public function getAnneeMiseEnService() {
        return $this->anneeMiseEnService;
    }

    public function getConstructeur() {
        return $this->constructeur;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPaysOrigine($paysOrigine) {
        $this->paysOrigine = $paysOrigine;
    }

    public function setAnneeMiseEnService($anneeMiseEnService) {
        $this->anneeMiseEnService = $anneeMiseEnService;
    }

    public function setConstructeur($constructeur) {
        $this->constructeur = $constructeur;
    }
}


?>