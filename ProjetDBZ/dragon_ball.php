
<?php 
//create class Personnage
class Personnage {
    protected $nom;//protecteb beacause the vaiables are use in other classes
    protected $niveau;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $peutAttaquer; 
    protected $tourRecharge;
    protected $estEnDefense;
    protected $super_attaque; 
    //create function construct
    protected function __construct($S, $A, $N, $D, $V) {//the constructor is protected because the other classes take the variables
        $this->super_attaque = $S;
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
    public function getVies() {//the function is public because it is used outside the class
        return $this->vies;
    }
    //create function getTourRecharge
    public function getTourRecharge() {//the function is public because it is used outside the class
        return $this->tourRecharge;
    }
    //create function choixAction
    public function choixAction($personnageAdverse) {//the function is public because it is used outside the class
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale({$this->attaque_speciale})\n";
        $action = intval(readline());
        //create switch for actions
        switch ($action) {
            case 1:
                $this->attaquer($personnageAdverse);//if it is 1 then we attack
                break;
            case 2:
                $this->seDefendre();//if it's 2 then we defend ourselves
                break;
            case 3://if it is 3 we make a specaial attack
                if ($this->tourRecharge === 0) {//the special attack has a cooldown
                    $this->attaqueSpeciale($personnageAdverse);//if there is more cooldown then the special attack can be performed
                } else {
                    echo "ki insuffisant. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";//otherwise it displays the cooldown time
                }
                break;
            default:
                echo "Choix invalide.\n";//otherwise the choice is not valid
                break;
        }
    }
    //create function attaquer
    public function attaquer($personnageAdverse) {//the function is public because it is used outside the class
        if ($personnageAdverse->estEnDefense) {//if during the attack the character opposite defends then the damage is not divided in two
            $degatsInfliges = $this->degats / 2;
            echo $this->nom . " attaque " . $personnageAdverse->getNom() . " en mode de défense et inflige " . $degatsInfliges . " dégâts.\n";
        } else {//the opponent takes all the damage from the attack if he does not defend
            $degatsInfliges = $this->degats;
            echo $this->nom . " attaque " . $personnageAdverse->getNom() . " et inflige " . $degatsInfliges . " dégâts.\n";
        }
        $personnageAdverse->prendreDegats($degatsInfliges);
        $this->peutAttaquer = false;
    }
    

    //create function seDefendre
    public function seDefendre() {//the function is public because it is used outside the class
        $this->peutAttaquer = false;
        $this->estEnDefense = true;
        echo $this->nom . " se prépare à se faire attaquer \n";
    }
    //create function attaqueSpeciale
    public function prendreDegats($degats) {//the function is public because it is used outside the class
        if ($this->peutAttaquer) {
            $this->vies -= $degats;
        } else {
            $this->vies -= $degats / 2;//if during the special attack the character opposite defends then the damage is not divided in two
        }
        if ($this->vies <= 0) {
            $this->mourir();//if the character's life drops to 0 then he dies
        }
    }
    //create function attaqueSpeciale
    public function attaqueSpeciale($personnageAdverse) {//the function is public because it is used outside the class
        if ($this->tourRecharge === 0) {//it takes 2 turns of cooldoawn otherwise the attack is not launched
            $degatsInfliges = 50;
            if ($personnageAdverse->estEnDefense) {
                $degatsInfliges /= 2;
                echo "{$this->nom} utilise son attaque spéciale ({$this->attaque_speciale}) sur {$personnageAdverse->getNom()}" . " en mode de défense et inflige " . $degatsInfliges . " dégâts.\n";
            } else {
                echo "{$this->nom} utilise son attaque spéciale ({$this->attaque_speciale}) sur {$personnageAdverse->getNom()}" . " et inflige " . $degatsInfliges . " dégâts.\n";
            }
    
            $personnageAdverse->prendreDegats($degatsInfliges);
            $this->tourRecharge = 2;
            $this->peutAttaquer = false;
        } else {
            echo "Ki insuffisant. Vous devez attendre encore " . $this->tourRecharge . " tours.\n";
        }
    }
    
    

    //create function tourSuivant
    public function tourSuivant() {//the function is public because it is used outside the class
        if ($this->tourRecharge > 0) {
            $this->tourRecharge--;
            if ($this->tourRecharge === 0) {// If the cooldown timer reaches 0, the special attack is recharged.
                echo $this->nom . " a rechargé son attaque spéciale!\n";
            }
        }
        $this->peutAttaquer = true;
    }
    //create function mourir
    public function mourir() {//the function is public because it is used outside the class
        echo $this->nom . " a été vaincu!\n";
    }
    //create function getNom
    public function getNom() {//the function is public because it is used outside the class
        return $this->nom;
    }

}
    //create class Heros
class Heros extends Personnage {
    private $premierEnnemiApparu = false;
    private $tourRechargeSuperAttaque = 0;//private because the variable is not used outside the class
    //create function construct
    public function __construct($super_attaque,$attaque_speciale, $nom, $degats, $vies) {//public because the constructor is used outside the class
        parent::__construct($super_attaque,$attaque_speciale, $nom, $degats, $vies);//it inherits from the parent constructor
    }
    public function gagnerCombat() {//the function is public because it is used outside the class
        $this->niveau++;//if the fight is won then it increases in level
        echo $this->nom . " a gagné le combat et atteint le niveau " . $this->niveau . "!\n";
    }
    //create function mourir
    public function superAttaque($personnageAdverse) {//the function is public because it is used outside the class
        if ($this->niveau >= 2) {
            if ($this->tourRechargeSuperAttaque === 0) {
                $degatsInfliges = 100;
                $personnageAdverse->prendreDegats($degatsInfliges);
                echo "{$this->nom} utilise sa super attaque ({$this->super_attaque}) sur {$personnageAdverse->getNom()}". " et inflige " . $degatsInfliges . " dégâts.\n";
                $this->peutAttaquer = false;
                $this->tourRechargeSuperAttaque = 3;
            } else {
                echo "La super attaque est en recharge. Vous devez attendre encore " . $this->tourRechargeSuperAttaque . " tours.\n";
            }
        } else {
            echo $this->nom . " doit être de niveau 2 pour utiliser sa super attaque.\n";
        }
    }
    
    //create function choixAction
    public function choixAction($personnageAdverse) {//the function is public because it is used outside the class
        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n2. Se défendre\n3. Attaque spéciale\n4. Super attaque\n";
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
                $this->superAttaque($personnageAdverse);
                break;
            default:
                echo "Choix invalide.\n";
                break;
        }
    }
    //create function attaquer
    public function tourSuivant() {//the function is public because it is used outside the class
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
        $this->peutAttaquer = true;
        $this->premierEnnemiApparu = true;
    }
}
    //create class Vilains
class Vilains extends Personnage {
    public function __construct($super_attaque,$attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($super_attaque,$attaque_speciale, $nom, $degats, $vies);
    }
    public function mourir() {//the function is public because it is used outside the class
        echo $this->nom . " a été vaincu!\n";
    }
    public function gagnerCombat() {//the function is public because it is used outside the class
        $this->niveau++;
        echo $this->nom . " a gagné le combat et atteint le niveau " . $this->niveau . "!\n";
    }
}
//create class Jeu
class Jeu {
    //create function combat
    public function combat($personnageJoueur, $personnageAdverse) {//the function is public because it is used outside the class
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
    }
}

$heros = array(
    new Heros( "Kamehameha","Genki Dama", "Son Goku", 36, 300),
    new Heros(" Big Bang Attack","Final Flash", "Vegeta", 30, 140),
    new Heros("Masenko","Special Beam Cannon", "Piccolo", 20, 130)
);
$vilains = array(
    new Vilains("Supernova","Death Ball", "Freezer", 40, 275),
    new Vilains("Absorption","Solar Kamehameha", "Cell", 28, 180),
    new Vilains("Attaque ventral","Planet Burst", "Buu", 34, 160)
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
        $herosActifs[] = $heros[1];
        $herosActifs[] = $heros[2];
        break;
    } else {
        echo "Héros invalide. Réessayez.\n";
    }
}

$jeu = new Jeu();

foreach ($vilains as $vilainsCombattant) {
    echo "Un nouveau combat commence!\n";
    $herosGagnants = [];
    
    foreach ($vilains as $vilainsCombattant) {
        echo "Un nouveau combat commence!\n";
        $herosGagnants = [];
    
        foreach ($herosActifs as $herosCombattant) {
            $jeu->combat($herosCombattant, $vilainsCombattant);
    
            if ($herosCombattant->getVies() > 0) {
                $herosGagnants[] = $herosCombattant;
            }
        }
    
        echo "Le combat est terminé!\n";
    
        if (empty($herosGagnants)) {
            echo "Tous les héros ont été vaincus. Les méchants l'emportent!\n";
        } else {
            foreach ($herosGagnants as $herosGagnant) {
                // Identifiez le héros gagnant ici
                $herosGagnant->gagnerCombat();
            }
        }
    }
}
    



