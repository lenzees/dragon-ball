<?php
class Personnage{
    protected $nom;
    protected $niveau_puissance;
    protected $vies;
    protected $attaque_special;
    protected $degats;

    public function __construct($A,$N,$D,$V)
    {
        $this->attaque_special=$A;
        $this->nom = $N;
        $this->niveau_puissance=1;
        $this->degats=$D;
        $this->vies=$V;
    }
    public function choixCamp(){
        echo "vous voulez être dans quel camp";
        $choix = strtolower(readline("1. Héros \n 2. Vilains"));
        $heros = array();
        $vilains = array();

        switch ($choix) {
            case '1':
            case 'héros':
                $heros[] = new Heros("Kamehameha", "Son Goku", "", 35, 300);
                $heros[] = new Heros("Final Flash", "Vegeta","", 30,140);
                $heros[] = new Heros("Special Beam Cannon", "Piccolo","",20, 130);
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

class heros extends Personnage{
    private $attaque_speciale;
    public $heros;

    public function __construct($attaque_speciale,$nom,$vie,$niveau_puissance)
    {
        parent::__construct($nom,$niveau_puissance,$vie);
        $this->attaque_speciale=$attaque_speciale;
        $this->heros = array();
    }
}

class vilains extends Personnage{
    private $attaque_speciale;
    private $attaque_vilaine;
    private $vilains;

    public function __construct($attaque_speciale,$nom,$vie,$niveau_puissance)
    {
        parent::__construct($nom,$niveau_puissance,$vie);
        $this->attaque_speciale=$attaque_speciale;
        $this->vilains = array();
    }
}