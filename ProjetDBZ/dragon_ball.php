<?php
class Personnage{
    protected $nom;
    protected $niveau_puissance;
    protected $vies;

    public function __construct($N,$V)
    {
        $this->niveau_puissance=1;
        $this->vies=$V;
    }
    public function choixCamp(){
        echo "vous voulez être dans quel camp";
        $choix = strtolower(readline("1. Héros \n 2. Vilains"));
        switch ($choix) {
            case '1' || 'héros':
                $heros = array("Son Goku","Vegeta","Piccolo");
                $vilains = array("Freezer","Cell","Buu","Babidi","Dabra","Broly","Bojack","Janemba","Cooler");
                break;
            case '2' || 'vilains':
                $heros = array("Son Goku","Gohan","Vegeta","Gotenks","Piccolo","Trunks","Krillin","Goten","C18");
                $vilains = array("freezer","cell","buu");
            default:
                # code...
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
        $this->heros = array("Son Goku","Gohan","Vegeta","Gotenks","Piccolo","Trunks","Krillin","Goten","C18");
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
        $this->vilains = array("Freezer","Cell","Buu","Babidi","Dabra","Broly","Bojack","Janemba","Cooler");
    }
}