<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

abstract class Projet extends BaseModel {
    protected $table = "projets";
    
    public function __construct(
        public $titre = "",
        public $description = "",
        public $membre_id = 0,
        public $date_debut = "",
        public $date_fin = "",
        public $budget = 0.00,
        public $statut = "en_attente",
        public $type_projet = ""
    ) {
        parent::__construct();
    }

    abstract public function calculerDuree();
    abstract public function getDetailsSpecifiques();

    public function create() {
        $stmt = $this->db->prepare(
            "INSERT INTO projets (titre, description, membre_id, date_debut, date_fin, budget, statut, type_projet)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $this->titre,
            $this->description,
            $this->membre_id,
            $this->date_debut,
            $this->date_fin,
            $this->budget,
            $this->statut,
            $this->type_projet
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id) {
        $stmt = $this->db->prepare(
            "UPDATE projets SET 
                titre = ?,
                description = ?,
                membre_id = ?,
                date_debut = ?,
                date_fin = ?,
                budget = ?,
                statut = ?,
                type_projet = ?
             WHERE id = ?"
        );
        return $stmt->execute([
            $this->titre,
            $this->description,
            $this->membre_id,
            $this->date_debut,
            $this->date_fin,
            $this->budget,
            $this->statut,
            $this->type_projet,
            $id
        ]);
    }

    public static function getAll() {
        $instance = new static();
        return $instance->db->query("SELECT * FROM projets")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $instance = new static();
        $stmt = $instance->db->prepare("SELECT * FROM projets WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByMembre($membre_id) {
        $instance = new static();
        $stmt = $instance->db->prepare("SELECT * FROM projets WHERE membre_id = ?");
        $stmt->execute([$membre_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }