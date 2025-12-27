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