<?php
namespace App\Models;

use App\Core\BaseModel;
use PDO;

class Activite extends BaseModel {
    public function __construct(
        public $nom = "",
        public $description = "",
        public $date_activite = "",
        public $duree_heures = 0,
        public $statut = "planifiee",
        public $projet_id = 0
    ) {
        parent::__construct();
    }

    public function create() {
        $stmt = $this->db->prepare(
            "INSERT INTO activites (nom, description, date_activite, duree_heures, statut, projet_id)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $this->nom,
            $this->description,
            $this->date_activite,
            $this->duree_heures,
            $this->statut,
            $this->projet_id
        ]);
        return $this->db->lastInsertId();
    }

    public function update($id) {
        $stmt = $this->db->prepare(
            "UPDATE activites SET 
                nom = ?,
                description = ?,
                date_activite = ?,
                duree_heures = ?,
                statut = ?
             WHERE id = ?"
        );
        return $stmt->execute([
            $this->nom,
            $this->description,
            $this->date_activite,
            $this->duree_heures,
            $this->statut,
            $id
        ]);
    }

    public static function getAll() {
        return (new self())->db->query("SELECT * FROM activites")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = (new self())->db;
        $stmt = $db->prepare("SELECT * FROM activites WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByProjet($projet_id) {
        $db = (new self())->db;
        $stmt = $db->prepare("SELECT * FROM activites WHERE projet_id = ? ORDER BY date_activite DESC");
        $stmt->execute([$projet_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        return (new self())->deleteById("activites", $id);
    }
}