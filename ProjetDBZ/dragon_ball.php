<?php
class Personnage {
    protected $nom;
    protected $niveau;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $peutAttaquer; 
    protected $tourRecharge;
    protected $estEnDefense; 

    public function __construct($A, $N, $D, $V) {
        $this->attaque_speciale = $A;
        $this->nom = $N;
        $this->niveau = 1;
        $this->degats = $D;
        $this->vies = $V;
        $this->peutAttaquer = true; 
        $this->tourRecharge = 2; 
        $this->estEnDefense = false; 
    }
    public function getVies() {
        return $this->vies;
    }
    public function getTourRecharge() {
        return $this->tourRecharge;
    }
    public function choixAction($cible) {
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale\n";
        $action = intval(readline());
        
        switch ($action) {
            case 1:
                $this->attaquer($cible);
                break;
            case 2:
                $this->seDefendre();
                break;
            case 3:
                if ($this->tourRecharge === 0) {
                    $this->attaqueSpeciale($cible);
                } else {
                    echo "L'attaque spéciale est en recharge. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
                }
                break;
            default:
                echo "Choix invalide.\n";
                break;
        }
    }
    public function attaquer($cible) {
        $degatsInfliges = $this->degats;
        $cible->prendreDegats($degatsInfliges);
        echo $this->nom . " attaque " . $cible->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
        $this->peutAttaquer = false; 
    }

    
    public function seDefendre() {
        $this->peutAttaquer = false;
        $this->estEnDefense = true;
        echo $this->nom . " se prépare à se faire attaquer \n";
    }
    
    public function prendreDegats($degats) {
        if ($this->peutAttaquer) {
            $this->vies -= $degats;
        } else {
            $this->vies -= $degats / 2;
        }
        if ($this->vies <= 0) {
            $this->mourir();
        }
    }

    public function attaqueSpeciale($cible) {
        if ($this->tourRecharge === 0) {
            $degatsInfliges = 50;
            $cible->prendreDegats($degatsInfliges);
            echo $this->nom . " utilise son attaque spéciale sur " . $cible->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
            $this->tourRecharge = 2;
            $this->peutAttaquer = false;
        } else {
            echo "L'attaque spéciale est en recharge. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
        }
    }
    


    public function tourSuivant() {
        if ($this->tourRecharge > 0) {
            $this->tourRecharge--;
            if ($this->tourRecharge === 0) {
                echo $this->nom . " a rechargé son attaque spéciale!\n";
            }
        }
        $this->peutAttaquer = true;
    }
    public function mourir() {
        echo $this->nom . " a été vaincu!\n";
    }

    public function getNom() {
        return $this->nom;
    }

}

class Heros extends Personnage {
    public function getAttaqueSpeciale() {
        return $this->attaque_speciale;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function victoire() {
        $this->niveau++;
    }

    public function reinitialiserRecharge() {
        $this->tourRecharge = 0;
    }
}

class Vilains extends Personnage {
    public function getAttaqueSpeciale() {
        return $this->attaque_speciale;
    }

    public function getNiveau() {
        return $this->niveau;
    }

    public function victoire() {
        $this->niveau++;
    }

    public function reinitialiserRecharge() {
        $this->tourRecharge = 0;
    }
}
class Jeu {
    public function combat($personnageJoueur, $personnageAdverse) {
        $tour = 1;

        while ($personnageJoueur->getVies() > 0 && $personnageAdverse->getVies() > 0) {
            echo "------------------------\n";
            echo "Tour $tour\n";

            echo "{$personnageJoueur->getNom()} - Vies : {$personnageJoueur->getVies()}\n";
            echo "{$personnageAdverse->getNom()} - Vies : {$personnageAdverse->getVies()}\n";

            if ($personnageJoueur instanceof Heros) {
                $this->gererActionsHeros($personnageJoueur, $personnageAdverse);
            } else {
                if ($personnageJoueur instanceof Vilains) {
                    $this->actionsAleatoiresPourVilain($personnageJoueur, $personnageAdverse);
                }
            }

            $personnageJoueur->tourSuivant();
            $temp = $personnageJoueur;
            $personnageJoueur = $personnageAdverse;
            $personnageAdverse = $temp;

            $tour++;
        }

        if ($personnageJoueur->getVies() <= 0) {
            echo "{$personnageAdverse->getNom()} a remporté le combat!\n";
        } else {
            echo "{$personnageJoueur->getNom()} a remporté le combat!\n";
        }
    }

    private function gererActionsHeros($personnageJoueur, $personnageAdverse) {
        // Gérer les actions pour le contrôle du héros
        $action = strtolower(readline("Choisissez une action :\n1. Attaquer\n2. Se défendre" . ($personnageJoueur->getNiveau() > 1 ? "\n3. Attaque spéciale" : "") . "Votre choix : "));
        switch ($action) {
            case '1':
                $personnageJoueur->attaquer($personnageAdverse);
                break;
            case '2':
                $personnageJoueur->seDefendre();
                break;
            case '3':
                if ($personnageJoueur->getNiveau() > 1) {
                    if ($personnageJoueur->getTourRecharge() === 0) {
                        $personnageJoueur->attaqueSpeciale($personnageAdverse);
                        $personnageJoueur->reinitialiserRecharge();
                    } else {
                        echo "L'attaque spéciale '" . $personnageJoueur->getAttaqueSpeciale() . "' est en recharge. Vous devez attendre encore " . $personnageJoueur->getTourRecharge() . " tours.\n";
                    }
                } else {
                    echo "{$personnageJoueur->getNom()} n'est pas de niveau 2 et ne peut pas utiliser d'attaque spéciale.\n";
                }
                break;
            default:
                echo "Action non valide. Réessayez.\n";
                $this->gererActionsHeros($personnageJoueur, $personnageAdverse);
                break;
        }
    }

    private function actionsAleatoiresPourVilain($personnageJoueur, $personnageAdverse) {
        // Générer des actions aléatoires pour le vilain
        $actionAleatoire = rand(1, 3); // 1: Attaquer, 2: Se défendre, 3: Attaque spéciale
        switch ($actionAleatoire) {
            case 1:
                $personnageJoueur->attaquer($personnageAdverse);
                break;
            case 2:
                $personnageJoueur->seDefendre();
                break;
            case 3:
                if ($personnageJoueur->getNiveau() > 1 && $personnageJoueur->getTourRecharge() === 0) {
                    $personnageJoueur->attaqueSpeciale($personnageAdverse);
                    $personnageJoueur->reinitialiserRecharge();
                }
                break;
        }
    }
}


$jeu = new Jeu();

$heros = array(
    new Heros("Kamehameha", "Son Goku", 35, 300),
    new Heros("Final Flash", "Vegeta", 30, 140),
    new Heros("Special Beam Cannon", "Piccolo", 20, 130)
);

$vilains = array(
    new Vilains("Death Ball", "Freezer", 40, 275),
    new Vilains("Solar Kamehameha", "Cell", 27, 180),
    new Vilains("Planet Burst", "Buu", 34, 160)
);

echo "Choisissez le héros avec lequel vous souhaitez commencer :\n";
for ($i = 0; $i < count($heros); $i++) {
    echo ($i + 1) . ". " . $heros[$i]->getNom() . "\n";
}

$choice = intval(readline("Votre choix : "));
if ($choice >= 1 && $choice <= count($heros)) {
    $herosCombattant = $heros[$choice - 1];
    
    foreach ($vilains as $vilainsCombattant) {
        echo "Un nouveau combat commence!\n";
        $jeu->combat($herosCombattant, $vilainsCombattant);
        echo "Le combat est terminé!\n";
    }
} else {
    echo "Choix invalide. Le héros n'existe pas.\n";
}










