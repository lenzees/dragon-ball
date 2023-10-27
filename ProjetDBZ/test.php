<?php 
//create class Personnage
class Personnage {
    protected $nom;
    protected $niveau;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $peutAttaquer; 
    protected $tourRecharge;
    protected $estEnDefense; 
    //create function construct
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
    //create function getVies
    public function getVies() {
        return $this->vies;
    }
    //create function getTourRecharge
    public function getTourRecharge() {
        return $this->tourRecharge;
    }
    //create function choixAction
    public function choixAction($personnageAdverse) {
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale\n";
        if ($this->niveau >= 2) {
            echo "4. Super attaque\n";
        }
        $action = intval(readline());
        //create switch
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
            case 4:
                if ($this->niveau >= 2) {
                    $this->superAttaque($personnageAdverse);
                } else {
                    echo "Niveau insuffisant. Vous devez attendre d'atteindre le niveau 2.\n";
                }
                break;
            default:
                echo "Choix invalide.\n";
                break;
        }
    }
    //create function attaquer
    public function attaquer($personnageAdverse) {
        $degatsInfliges = $this->degats;
        $personnageAdverse->prendreDegats($degatsInfliges);
        echo $this->nom . " attaque " . $personnageAdverse->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
        $this->peutAttaquer = false; 
    }

    //create function seDefendre
    public function seDefendre() {
        $this->peutAttaquer = false;
        $this->estEnDefense = true;
        echo $this->nom . " se prépare à se faire attaquer \n";
    }
    //create function attaqueSpeciale
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
    //create function attaqueSpeciale
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
    
    //create function tourSuivant
    public function tourSuivant() {
        $this->niveau += 1;
        if ($this->niveau >= 2) {
            if ($this->tourRecharge > 0) {
                $this->tourRecharge--;
                if ($this->tourRecharge === 0) {
                    echo $this->nom . " a rechargé son attaque spéciale!\n";
                }
            }
        }
        $this->peutAttaquer = true;
    }
    //create function mourir
    public function mourir() {
        echo $this->nom . " a été vaincu!\n";
    }
    //create function getNom
    public function getNom() {
        return $this->nom;
    }

}
    //create class Heros
class Heros extends Personnage {
    private $premierEnnemiApparu = false;
    private $tourRechargeSuperAttaque = 0;
    //create function construct
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
    //create function mourir
    public function superAttaque($personnageAdverse) {
        if ($this->premierEnnemiApparu) {
            if ($this->tourRechargeSuperAttaque === 0) {
                $degatsInfliges = 100;
                $personnageAdverse->prendreDegats($degatsInfliges);
                echo $this->nom . " utilise sa super attaque sur " . $personnageAdverse->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
                $this->peutAttaquer = false;
                $this->tourRechargeSuperAttaque = 3;
            } else {
            echo "La super attaque est en recharge. Vous devez attendre encore " . $this->tourRechargeSuperAttaque . " tours.\n";
            }
        }
            else {
            echo "Vous n'avez pas encore débloqué votre super attaque.\n";
        }
    }
    //create function choixAction
    public function choixAction($personnageAdverse) {
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale\n";
        if ($this->niveau >= 2) {
            echo "4. Super attaque\n";
        }
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
                    echo "Ki insuffisant. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
                }
                break;
            case 4:
                if ($this->niveau >= 2) {
                    $this->superAttaque($personnageAdverse);
                } else {
                    echo "Niveau insuffisant. Vous devez attendre d'atteindre le niveau 2.\n";
                }
                break;
            default:
                echo "Choix invalide.\n";
                break;
        }
    }
    //create function attaquer
    public function tourSuivant() {
        $this->niveau += 1;
        if ($this->niveau >= 2) {
            if ($this->tourRecharge > 0) {
                $this->tourRecharge--;
                if ($this->tourRecharge === 0) {
                    echo $this->nom . " a rechargé son attaque spéciale!\n";
                }
            }
            if ($this->tourRechargeSuperAttaque > 0) {
                $this->tourRechargeSuperAttaque--;
                if ($this->tourRechargeSuperAttaque === 0) {
                    echo $this->nom . " a rechargé sa super attaque!\n";
                }
            }
        }
        $this->peutAttaquer = true;
        $this->premierEnnemiApparu = true;
    }
}
    //create class Vilains
class Vilains extends Personnage {
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
    public function mourir() {
        echo $this->nom . " a été vaincu!\n";
    }
}
//create class Jeu
class Jeu {
    //create function combat
    public function combat($personnageJoueur, $personnageAdverse) {
        $tour = 1;
        //create while loop 
        while ($personnageJoueur->getVies() > 0 && $personnageAdverse->getVies() > 0) {
            echo "------------------------\n";
            echo "Tour $tour\n";

            echo "{$personnageJoueur->getNom()} - Vies : {$personnageJoueur->getVies()}\n";
            echo "{$personnageAdverse->getNom()} - Vies : {$personnageAdverse->getVies()}\n";
            //create if statement
            if ($personnageJoueur instanceof Heros) {
                $personnageJoueur->choixAction($personnageAdverse);
            } else {
                $actionAleatoire = rand(1, 3); // 1: Attaquer, 2: Se défendre, 3: Attaque spéciale
                //create switch
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
                            echo "Le ki de {$personnageJoueur->getNom()} n'est suffisant pour lancer l'attaque specile. Il doit attendre encore " . $personnageJoueur->getTourRecharge() . " tours.\n";
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

$herosActifs = [];
$herosChoisi = null;

while (true) {
    echo "Héros disponibles:\n";
    foreach ($heros as $index => $herosCombattant) {
        echo ($index + 1) . ". " . $herosCombattant->getNom() . "\n";
    }
    $choix = (readline("Entrez le numéro du héros que vous voulez choisir : ")) - 1;

    if (isset($heros[$choix])) {
        $herosChoisi = $heros[$choix];
        echo "Vous avez choisi {$herosChoisi->getNom()} comme héros.\n";
        $herosActifs[] = $herosChoisi;
        // Ajoutez deux autres héros par défaut
        $herosActifs[] = $heros[1]; // Ajoutez Vegeta
        $herosActifs[] = $heros[2]; // Ajoutez Piccolo
        break;
    } else {
        echo "Héros invalide. Réessayez.\n";
    }
}

$jeu = new Jeu();

foreach ($vilains as $vilainsCombattant) {
    foreach ($herosActifs as $herosCombattant) {
        echo "Un nouveau combat commence!\n";
        $jeu->combat($herosCombattant, $vilainsCombattant);
        echo "Le combat est terminé!\n";

        if ($herosCombattant->getVies() <= 0) {
            echo "{$herosCombattant->getNom()} a été vaincu!\n";
            $key = array_search($herosCombattant, $herosActifs);
            if ($key !== false) {
                unset($herosActifs[$key]);
            }

            if (empty($herosActifs)) {
                echo "Tous les héros ont été vaincus. Les méchants l'emportent!\n";
                break 2;
            }
        }
    }
}