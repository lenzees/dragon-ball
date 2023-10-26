<?php
class Personnage {
    public $nom;
    public $niveau_puissance;
    public $vies;
    public $degats;

    public function __construct($nom, $niveau_puissance, $vies, $degats) {
        $this->nom = $nom;
        $this->niveau_puissance = $niveau_puissance;
        $this->vies = $vies;
        $this->degats = $degats;
    }

    public function attaquer($adversaire) {
        $adversaire->prendreDegats($this->degats);
    }

    public function prendreDegats($degats) {
        $this->vies -= $degats;

        if ($this->vies <= 0) {
            $this->vies = 0;
            $this->mourir();
        }
    }

    public function mourir() {
        echo "{$this->nom} est mort !\n";
    }

    public function afficherStats() {
        echo "{$this->nom} ({$this->niveau_puissance}) : {$this->vies} vies, {$this->degats} dégâts\n";
    }
}

class Heros extends Personnage {
    private $attaque_speciale = "Kamehameha";

    public function attaquer($adversaire) {
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n";
        echo "2. Se défendre\n";
        echo "3. Attaque spéciale ({$this->attaque_speciale})\n";
        $choix = readline("Entrez votre choix : ");

        switch ($choix) {
            case 1:
                parent::attaquer($adversaire);
                break;
            case 2:
                echo "{$this->nom} se défend !\n";
                break;
            case 3:
                echo "{$this->nom} utilise son attaque spéciale {$this->attaque_speciale} !\n";
                $adversaire->prendreDegats($this->degats * 2);
                break;
            default:
                echo "Choix invalide !\n";
                break;
        }
    }

    public function debloquerAttaque() {
        echo "{$this->nom} débloque une nouvelle attaque : Kamehameha !\n";
    }
}

class Vilains extends Personnage {
    public function attaquer($adversaire) {
        if (rand(1, 2) == 1) {
            $adversaire->prendreDegats($this->degats * 2);
            echo "{$this->nom} attaque {$adversaire->nom} avec une attaque spéciale !\n";
        } else {
            parent::attaquer($adversaire);
        }
    }
}

echo "Bienvenue dans le monde de Dragon Ball !\n";

echo "Choisissez votre camp :\n";
echo "1. Héros\n";
echo "2. Vilain\n";
$choix = readline("Entrez votre choix : ");

if ($choix == 1) {
    $joueur = new Heros("Goku", 9000, 100, 20);
    $adversaire = new Vilains("Freezer", 10000, 120, 30);
} else {
    $joueur = new Vilains("Freezer", 10000, 120, 30);
    $adversaire = new Heros("Goku", 9000, 100, 20);
}

$manches = 3;

for ($i = 1; $i <= $manches; $i++) {
    echo "\n\nManche {$i} !\n";
    $joueur->afficherStats();
    $adversaire->afficherStats();

    echo "C'est l'heure du combat !\n";
    echo "Il était une fois un combat épique entre {$joueur->nom} et {$adversaire->nom}...\n";

    while ($joueur->vies > 0 && $adversaire->vies > 0) {
        echo "\nQue voulez-vous faire ?\n";
        echo "1. Attaquer\n";
        echo "2. Se défendre\n";
        echo "3. Quitter le combat\n";
        $choix = readline("Entrez votre choix : ");

        switch ($choix) {
            case 1:
                $joueur->attaquer($adversaire);
                break;
            case 2:
                echo "{$joueur->nom} se défend !\n";
                break;
            case 3:
                echo "Vous avez quitté le combat !\n";
                exit;
            default:
                echo "Choix invalide !\n";
                break;
        }

        if ($adversaire->vies <= 0) {
            echo "{$joueur->nom} a gagné le round !\n";
            $joueur->debloquerAttaque();
            break;
        }

        $adversaire->attaquer($joueur);

        if ($joueur->vies <= 0) {
            echo "{$adversaire->nom} a gagné le round !\n";
            break;
        }
    }

    echo "Fin de la manche !\n";
    $joueur->afficherStats();
    $adversaire->afficherStats();
    echo "Il était une fois un combat épique entre {$joueur->nom} et {$adversaire->nom}...\n";
    echo "{$joueur->nom} a {$joueur->vies} vies et {$adversaire->nom} a {$adversaire->vies} vies.\n";
}

echo "Fin du jeu !\n";
$joueur->afficherStats();

// Sauvegarde de la partie
$partie = array(
    "nom" => $joueur->nom,
    "camp" => $choix == 1 ? "hero" : "vilain",
    "vies" => $joueur->vies,
    "degats" => $joueur->degats
);

file_put_contents("partie.json", json_encode($partie));