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

function menuProjets() {
    while (true) {
        echo "\n--- PROJETS ---\n";
        echo "1. Ajouter projet court\n";
        echo "2. Ajouter projet long\n";
        echo "3. Lister\n";
        echo "4. Consulter\n";
        echo "5. Modifier\n";
        echo "6. Supprimer\n";
        echo "7. Retour\n";
        echo "Choix : ";
        $c = trim(fgets(STDIN));

        if ($c == '1') {
            echo "Titre : "; $t = trim(fgets(STDIN));
            echo "Description : "; $d = trim(fgets(STDIN));
            echo "ID Membre : "; $m = trim(fgets(STDIN));
            echo "Date début (YYYY-MM-DD) : "; $dd = trim(fgets(STDIN));
            echo "Date fin (YYYY-MM-DD) : "; $df = trim(fgets(STDIN));
            echo "Budget : "; $b = trim(fgets(STDIN));
            echo "Statut (en_attente/en_cours/termine/annule) : "; $s = trim(fgets(STDIN));

            try {
                $p = new ProjetCourt($t, $d, $m, $dd, $df, $b, $s);
                $id = $p->create();
                echo " Projet court ajouté (ID: $id)\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '2') {
            echo "Titre : "; $t = trim(fgets(STDIN));
            echo "Description : "; $d = trim(fgets(STDIN));
            echo "ID Membre : "; $m = trim(fgets(STDIN));
            echo "Date début (YYYY-MM-DD) : "; $dd = trim(fgets(STDIN));
            echo "Date fin (YYYY-MM-DD) : "; $df = trim(fgets(STDIN));
            echo "Budget : "; $b = trim(fgets(STDIN));
            echo "Statut (en_attente/en_cours/termine/annule) : "; $s = trim(fgets(STDIN));

            try {
                $p = new ProjetLong($t, $d, $m, $dd, $df, $b, $s);
                $id = $p->create();
                echo " Projet long ajouté (ID: $id)\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '3') {
            try {
                $projets = ProjetCourt::getAll();
                if (empty($projets)) {
                    echo "Aucun projet enregistré.\n";
                } else {
                    foreach ($projets as $p) {
                        echo "{$p['id']} | {$p['titre']} | {$p['type_projet']} | membre {$p['membre_id']}\n";
                    }
                }
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '4') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                $p = ProjetCourt::findById($id);
                if ($p) {
                    echo "ID: {$p['id']}\n";
                    echo "Titre: {$p['titre']}\n";
                    echo "Description: {$p['description']}\n";
                    echo "Type: {$p['type_projet']}\n";
                    echo "Membre ID: {$p['membre_id']}\n";
                    echo "Date début: {$p['date_debut']}\n";
                    echo "Date fin: {$p['date_fin']}\n";
                    echo "Budget: {$p['budget']}\n";
                    echo "Statut: {$p['statut']}\n";
                } else {
                    echo "Projet introuvable\n";
                }
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '5') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                $old = ProjetCourt::findById($id);
                if (!$old) { 
                    echo " Projet introuvable\n"; 
                    continue; 
                }

                echo "Titre ({$old['titre']}): "; $t = trim(fgets(STDIN));
                if (empty($t)) $t = $old['titre'];
                
                echo "Description ({$old['description']}): "; $d = trim(fgets(STDIN));
                if (empty($d)) $d = $old['description'];
                
                echo "Membre ID ({$old['membre_id']}): "; $m = trim(fgets(STDIN));
                if (empty($m)) $m = $old['membre_id'];
                
                echo "Date début ({$old['date_debut']}): "; $dd = trim(fgets(STDIN));
                if (empty($dd)) $dd = $old['date_debut'];
                
                echo "Date fin ({$old['date_fin']}): "; $df = trim(fgets(STDIN));
                if (empty($df)) $df = $old['date_fin'];
                
                echo "Budget ({$old['budget']}): "; $b = trim(fgets(STDIN));
                if (empty($b)) $b = $old['budget'];
                
                echo "Statut ({$old['statut']}): "; $s = trim(fgets(STDIN));
                if (empty($s)) $s = $old['statut'];
                
                echo "Type ({$old['type_projet']}): "; $ty = trim(fgets(STDIN));
                if (empty($ty)) $ty = $old['type_projet'];

                if ($ty == 'court') {
                    $projet = new ProjetCourt($t, $d, $m, $dd, $df, $b, $s);
                } else {
                    $projet = new ProjetLong($t, $d, $m, $dd, $df, $b, $s);
                }
                
                $projet->update($id);
                echo " Projet modifié\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '6') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                ProjetCourt::delete($id);
                echo " Projet supprimé\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '7') return;
    }
}
function menuActivites() {
    while (true) {
        echo "\n--- ACTIVITES ---\n";
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
            echo "Description : "; $d = trim(fgets(STDIN));
            echo "Date (YYYY-MM-DD HH:MM:SS) : "; $da = trim(fgets(STDIN));
            echo "Durée (heures) : "; $dh = trim(fgets(STDIN));
            echo "Statut (planifiee/en_cours/terminee/annulee) : "; $s = trim(fgets(STDIN));
            echo "Projet ID : "; $p = trim(fgets(STDIN));

            try {
                $a = new Activite($n, $d, $da, $dh, $s, $p);
                $id = $a->create();
                echo " Activité ajoutée (ID: $id)\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '2') {
            try {
                $activites = Activite::getAll();
                if (empty($activites)) {
                    echo "Aucune activité enregistrée.\n";
                } else {
                    foreach ($activites as $a) {
                        echo "{$a['id']} | {$a['nom']} | projet {$a['projet_id']}\n";
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
                $a = Activite::findById($id);
                if ($a) {
                    echo "ID: {$a['id']}\n";
                    echo "Nom: {$a['nom']}\n";
                    echo "Description: {$a['description']}\n";
                    echo "Date: {$a['date_activite']}\n";
                    echo "Durée: {$a['duree_heures']} heures\n";
                    echo "Statut: {$a['statut']}\n";
                    echo "Projet ID: {$a['projet_id']}\n";
                } else {
                    echo " Activité introuvable\n";
                }
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '4') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                $old = Activite::findById($id);
                if (!$old) { 
                    echo " Activité introuvable\n"; 
                    continue; 
                }

                echo "Nom ({$old['nom']}): "; $n = trim(fgets(STDIN));
                if (empty($n)) $n = $old['nom'];
                
                echo "Description ({$old['description']}): "; $d = trim(fgets(STDIN));
                if (empty($d)) $d = $old['description'];
                
                echo "Date ({$old['date_activite']}): "; $da = trim(fgets(STDIN));
                if (empty($da)) $da = $old['date_activite'];
                
                echo "Durée ({$old['duree_heures']}): "; $dh = trim(fgets(STDIN));
                if (empty($dh)) $dh = $old['duree_heures'];
                
                echo "Statut ({$old['statut']}): "; $s = trim(fgets(STDIN));
                if (empty($s)) $s = $old['statut'];
                
                echo "Projet ID ({$old['projet_id']}): "; $p = trim(fgets(STDIN));
                if (empty($p)) $p = $old['projet_id'];

                $a = new Activite($n, $d, $da, $dh, $s, $p);
                $a->update($id);
                echo " Activité modifiée\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

  
        if ($c == '5') {
            echo "ID : ";
            $id = trim(fgets(STDIN));
            try {
                Activite::delete($id);
                echo "✔ Activité supprimée\n";
            } catch (\Exception $e) {
                echo " Erreur : " . $e->getMessage() . "\n";
            }
        }

        if ($c == '6') return;
    }
}

echo "\n========================================\n";
echo "   GESTION DE PROJETS - APPLICATION\n";
echo "========================================\n";

while (true) {
    menuPrincipal();
    $c = trim(fgets(STDIN));

    if ($c == '1') menuMembres();
    elseif ($c == '2') menuProjets();
    elseif ($c == '3') menuActivites();
    elseif ($c == '4') {
        echo "\n Au revoir !\n";
        exit(0);
    } else {
        echo " Choix invalide\n";
    }
}
