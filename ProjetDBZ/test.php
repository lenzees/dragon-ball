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
    public function choixAction($personnageAdverse) {
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale\n";
        $action = intval(readline());
        
        switch ($action) {
            case 1:
                $this->attaquer($personnageAdverse);
                break;
            case 2:
                $this->seDefendre();
                break;
            case 3:
                if ($this->tourRecharge === 0) {
                    $this->attaqueSpeciale($personnageAdverse);
                } else {
                    echo "ki insuffisant. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
                }
                break;
            default:
                echo "Choix invalide.\n";
                break;
        }
    }
    public function attaquer($personnageAdverse) {
        $degatsInfliges = $this->degats;
        $personnageAdverse->prendreDegats($degatsInfliges);
        echo $this->nom . " attaque " . $personnageAdverse->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
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

    public function attaqueSpeciale($personnageAdverse) {
        if ($this->tourRecharge === 0) {
            $degatsInfliges = 50;
            $personnageAdverse->prendreDegats($degatsInfliges);
            echo $this->nom . " utilise son attaque spéciale sur " . $personnageAdverse->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
            $this->tourRecharge = 2;
            $this->peutAttaquer = false;
        } else {
            echo "Ki insuffisant. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
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
            echo "------------------------\n";
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
                            echo "Le ki de {$personnageJoueur->getNom()} n'est suffisant pour lancer l'attaque specile. Vous devez attendre encore " . $personnageJoueur->getTourRecharge() . " tours.\n";
                        }
                        break;
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
}

$jeu = new Jeu();

$heros = array(
    new Heros("Kamehameha", "Son Goku", 35, 300),
    new Heros("Final Flash", "Vegeta", 30, 140),
    new Heros("Special Beam Cannon", "Piccolo", 20, 130)
);

echo "Choisissez votre héros:\n";
foreach ($heros as $key => $hero) {
    echo ($key + 1) . ". " . $hero->getNom() . "\n";
}
$heroIndex = intval(readline()) - 1;
$heroChoisi = $heros[$heroIndex];

$vilains = array(
    new Vilains("Death Ball", "Freezer", 40, 275),
    new Vilains("Solar Kamehameha", "Cell", 27, 180),
    new Vilains("Planet Burst", "Buu", 34, 160)
);

foreach ($vilains as $vilainsCombattant) {
    echo "Un nouveau combat commence!\n";
    $jeu->combat($heroChoisi, $vilainsCombattant);
    echo "Le combat est terminé!\n";
}