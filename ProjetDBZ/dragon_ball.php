<?php
class Personnage {
    protected $nom;
    protected $niveau_puissance;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;

    public function __construct($A, $N, $D, $V) {
        $this->attaque_speciale = $A;
        $this->nom = $N;
        $this->niveau_puissance = 1;
        $this->degats = $D;
        $this->vies = $V;
    }

    public function choixCamp() {
        echo "Vous voulez être dans quel camp ?\n";
        $choix = strtolower(readline("1. Héros \n2. Vilains\n"));
        
        $heros = array();
        $vilains = array();

        switch ($choix) {
            case '1':
            case 'héros':
                $heros[] = new Heros("Kamehameha", "Son Goku", 35, 300);
                $heros[] = new Heros("Final Flash", "Vegeta", 30, 140);
                $heros[] = new Heros("Special Beam Cannon", "Piccolo", 20, 130);
                break;

            case '2':
            case 'vilains':
                $vilains[] = new Vilains("Death Ball", "Freezer", 40, 275);
                $vilains[] = new Vilains("Solar Kamehameha", "Cell", 27, 180);
                $vilains[] = new Vilains("Planet Burst", "Buu", 34, 160);
                break;

            default:
                echo "Choix invalide.\n";
                break;
        }
    }
}

class Heros extends Personnage {
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
}

class Vilains extends Personnage {
    public function __construct($attaque_speciale, $nom, $degats, $vies) {
        parent::__construct($attaque_speciale, $nom, $degats, $vies);
    }
}
echo "Bienvenue dans le jeu Dragon Ball !\n";