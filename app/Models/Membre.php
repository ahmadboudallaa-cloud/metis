<?php
namespace App\Models;

use App\Core\BaseModel;
use App\Utils\Validator;
use PDO;

class Membre extends BaseModel {
    protected $table = "membres";

    public function __construct(
        public $nom = "",
        public $prenom = "",
        public $email = "",
        public $telephone = ""
    ) {
        parent::__construct();
    }

    public function create() {
        if (!Validator::email($this->email)) {
            throw new \Exception("Email invalide");
        }

    
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM membres WHERE email = ?");
        $stmt->execute([$this->email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            throw new \Exception("Cet email est déjà utilisé");
        }

        $stmt = $this->db->prepare(
            "INSERT INTO membres (nom, prenom, email, telephone)
             VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$this->nom, $this->prenom, $this->email, $this->telephone]);
        return $this->db->lastInsertId();
    }

    public function update($id) {
        if (!Validator::email($this->email)) {
            throw new \Exception("Email invalide");
        }

        
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM membres WHERE email = ? AND id != ?");
        $stmt->execute([$this->email, $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            throw new \Exception("Cet email est déjà utilisé par un autre membre");
        }

        $stmt = $this->db->prepare(
            "UPDATE membres SET 
                nom = ?,
                prenom = ?,
                email = ?,
                telephone = ?
             WHERE id = ?"
        );
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->telephone, $id]);
    }

    public static function getAll() {
        $db = (new self())->db;
        return $db->query("SELECT * FROM membres")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = (new self())->db;
        $stmt = $db->prepare("SELECT * FROM membres WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
      
        $db = (new self())->db;
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM projets WHERE membre_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            throw new \Exception("Impossible de supprimer le membre : il est associé à des projets");
        }
        
        return (new self())->deleteById("membres", $id);
    }
}