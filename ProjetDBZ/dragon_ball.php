<?php
class Personnage{
    protected $nom;
    protected $niveau_puissance;
    protected $vies;

    public function __construct($N,$Nv,$V)
    {
        $this->nom=$N;
        $this->niveau_puissance=1;
        $this->vies=$V;
    }
}

class heros extends Personnage{
    private $attaque_speciale;
    private $heros;

    public function __construct($attaque_speciale,$nom,$vie,$niveau_puissance)
    {
        parent::__construct($nom,$niveau_puissance,$vie);
        $this->attaque_speciale=$attaque_speciale;
        $this->heros = array("Son Goku","Gohan","Vegeta","Gotenks","Piccolo","Trunks","Krillin","Goten","C18");
    }
}

class vilains extends Personnage{
    private $attaque_speciale;
    private $vilains;

    public function __construct($attaque_speciale,$nom,$vie,$niveau_puissance)
    {
        parent::__construct($nom,$niveau_puissance,$vie);
        $this->attaque_speciale=$attaque_speciale;
        $this->vilains = array("Freezer","Cell","Buu","Babidi","Dabra","Broly","Bojack","Janemba","Cooler");
    }
}