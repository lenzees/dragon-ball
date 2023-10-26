<?php
class Personnage {
    protected $nom;
    protected $niveau_puissance;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $peutAttaquer; 
    protected $tourRecharge;
    protected $estEnDefense; 

    public function __construct($A, $N, $D, $V) {
        $this->attaque_speciale = $A;
        $this->nom = $N;
        $this->niveau_puissance = 1;
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
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
    public function mourir() {
        echo $this->nom . " a été vaincu!\n";
    }
}

class Vilains extends Personnage {
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
    public function mourir() {
        echo $this->nom . " a été vaincu!\n";
    }
}
class Jeu {
    public function combat($personnageJoueur, $personnageAdverse) {
        $tour = 1;

        while ($personnageJoueur->getVies() > 0 && $personnageAdverse->getVies() > 0) {
            echo "Tour $tour\n";

            echo "{$personnageJoueur->getNom()} - Vies : {$personnageJoueur->getVies()}\n";
            echo "{$personnageAdverse->getNom()} - Vies : {$personnageAdverse->getVies()}\n";

            if ($personnageJoueur instanceof Heros) {
                $personnageJoueur->choixAction($personnageAdverse);
            } else {
                $actionAleatoire = rand(1, 3); // 1: Attaquer, 2: Se défendre, 3: Attaque spéciale
                switch ($actionAleatoire) {
                    case 1:
                        $personnageJoueur->attaquer($personnageAdverse);
                        break;
                    case 2:
                        $personnageJoueur->seDefendre();
                        break;
                    case 3:
                        if ($personnageJoueur->getTourRecharge() === 0) {
                            $personnageJoueur->attaqueSpeciale($personnageAdverse);
                        } else {
                            echo "L'attaque spéciale est en recharge. Vous devez attendre encore " . $personnageJoueur->getTourRecharge() . " tours.\n";
                        }
                        break;
                }
            }
            $personnageJoueur->tourSuivant();
            // Permutez les rôles des personnages
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
}





$jeu = new Jeu();

echo "Vous voulez être dans quel camp ?\n";
$choixCamp = strtolower(readline("1. Héros \n2. Vilains\n"));

if ($choixCamp == '1' || $choixCamp == 'héros') {
    // Créez une instance de héros
    $heros = new Heros("Kamehameha", "Son Goku", 35, 300);
    
    // Créez une instance de vilain (l'adversaire)
    $vilain = new Vilains("Death Ball", "Freezer", 40, 275);
} else if ($choixCamp == '2' || $choixCamp == 'vilains') {
    // Créez une instance de vilain
    $vilain = new Vilains("Death Ball", "Freezer", 40, 275);
    
    // Créez une instance de héros (l'adversaire)
    $heros = new Heros("Kamehameha", "Son Goku", 35, 300);
}

// Faites combattre les héros et les vilains
$jeu->combat($heros, $vilain);