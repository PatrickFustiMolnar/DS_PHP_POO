<?php

class ManagerAvion {
    private $avions = []; // Tableau pour stocker les objets Avion
    private $nextId = 1;  // Variable pour simuler les IDs auto-incrémentés

    // Ajouter un avion à la liste
    public function add(Avion $avion) {
        // On assigne un ID unique à l'avion
        $avion->setId($this->nextId);
        $this->avions[$this->nextId] = $avion;
        $this->nextId++;
    }

    // Récupérer un avion par ID
    public function get($id) {
        if (isset($this->avions[$id])) {
            return $this->avions[$id];
        }
        return null;
    }

    // Récupérer tous les avions
    public function getAll() {
        return $this->avions;
    }
    
    // Supprimer un avion par ID
    public function remove($id) {
        if (isset($this->avions[$id])) {
            unset($this->avions[$id]);
        }
    }
}





?>