<?php
spl_autoload_register(function ($class) {
    $class = str_replace("App\\", "", $class);
    $path = __DIR__ . "/../app/" . str_replace("\\", "/", $class) . ".php";
    if (file_exists($path)) require $path;
});

use App\Models\Membre;
use App\Models\ProjetCourt;
use App\Models\ProjetLong;
use App\Models\Activite;

function menuPrincipal() {
    echo "\n===== MENU PRINCIPAL =====\n";
    echo "1. Membres\n";
    echo "2. Projets\n";
    echo "3. Activités\n";
    echo "4. Quitter\n";
    echo "Choix : ";
}

function menuMembres() {
    while (true) {
        echo "\n--- MEMBRES ---\n";
        echo "1. Ajouter\n";
        echo "2. Lister\n";
        echo "3. Consulter\n";
        echo "4. Modifier\n";
        echo "5. Supprimer\n";
        echo "6. Retour\n";
        echo "Choix : ";

        $c = trim(fgets(STDIN));

        if ($c == '1') {
            echo "Nom : "; $n = trim(fgets(STDIN));
            echo "Prénom : "; $p = trim(fgets(STDIN));
            echo "Email : "; $e = trim(fgets(STDIN));
            echo "Téléphone : "; $t = trim(fgets(STDIN));

            try {
                $m = new Membre($n, $p, $e, $t);
                $id = $m->create();
                echo " Membre ajouté (ID: $id)\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '2') {
            try {
                $membres = Membre::getAll();
                if (empty($membres)) {
                    echo "Aucun membre enregistré.\n";
                } else {
                    foreach ($membres as $m) {
                        echo "{$m['id']} | {$m['nom']} {$m['prenom']} | {$m['email']}\n";
                    }
                }
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '3') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                $m = Membre::findById($id);
                if ($m) {
                    echo "ID: {$m['id']}\n";
                    echo "Nom: {$m['nom']}\n";
                    echo "Prénom: {$m['prenom']}\n";
                    echo "Email: {$m['email']}\n";
                    echo "Téléphone: {$m['telephone']}\n";
                } else {
                    echo " Membre introuvable\n";
                }
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

       
        if ($c == '4') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                $old = Membre::findById($id);
                if (!$old) { 
                    echo " Membre introuvable\n"; 
                    continue; 
                }

                echo "Nom ({$old['nom']}): "; $n = trim(fgets(STDIN));
                if (empty($n)) $n = $old['nom'];
                
                echo "Prénom ({$old['prenom']}): "; $p = trim(fgets(STDIN));
                if (empty($p)) $p = $old['prenom'];
                
                echo "Email ({$old['email']}): "; $e = trim(fgets(STDIN));
                if (empty($e)) $e = $old['email'];
                
                echo "Téléphone ({$old['telephone']}): "; $t = trim(fgets(STDIN));
                if (empty($t)) $t = $old['telephone'];

                $m = new Membre($n, $p, $e, $t);
                $m->update($id);
                echo " Membre modifié\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

     
        if ($c == '5') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                Membre::delete($id);
                echo " Membre supprimé\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '6') return;
    }
}
