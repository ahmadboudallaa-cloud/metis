<?php
namespace App\Models;

class ProjetLong extends Projet {
    private $duree_jours = 180;
    private $priorite = 'Moyenne';

    public function __construct(
        $titre = '',
        $description = '',
        $membre_id = 0,
        $date_debut = '',
        $date_fin = '',
        $budget = 0.00,
        $statut = 'en_attente'
    ) {
        parent::__construct($titre, $description, $membre_id, $date_debut, $date_fin, $budget, $statut, 'long');
    }

   
    public function getDureeJours() { 
        return $this->duree_jours; 
    }
    
    public function getPriorite() { 
        return $this->priorite; 
    }

    public function setDureeJours($duree_jours) {
        if ($duree_jours >= 91 && $duree_jours <= 365) {
            $this->duree_jours = (int)$duree_jours;
        } else {
            throw new \InvalidArgumentException("La durée doit être entre 91 et 365 jours pour un projet long");
        }
    }

    public function setPriorite($priorite) {
        $prioritesValides = ['Basse', 'Moyenne', 'Haute'];
        if (in_array($priorite, $prioritesValides)) {
            $this->priorite = $priorite;
        } else {
            throw new \InvalidArgumentException("Priorité invalide. Choisissez entre : Basse, Moyenne, Haute");
        }
    }

    public function calculerDuree() {
        if (!empty($this->date_debut) && !empty($this->date_fin)) {
            $debut = new \DateTime($this->date_debut);
            $fin = new \DateTime($this->date_fin);
            $interval = $debut->diff($fin);
            return $interval->days;
        }
        return $this->duree_jours;
    }

    public function getDetailsSpecifiques() {
        return [
            'type' => 'Projet Long',
            'duree_jours' => $this->calculerDuree(),
            'priorite' => $this->priorite,
            'duree_min' => 91
        ];
    }
}