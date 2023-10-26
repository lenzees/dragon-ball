<?php
class Personnage{
    protected $nom;
    protected $niveau_puissance;
    protected $vies;

    public function __construct($N,$Nv,$V)
    {
        $this->nom=$N;
        $this->niveau_puissance=$Nv;
        $this->vies=$V;
    }
}
class heros extends Personnage{
    private $attaque_speciale;

 public function __construct($attaque_speciale,$nom,$vie,$niveau_puissabce)
 parent::__construct($N,$Nv,$V)
 {
        $this->nom=$nom;
        $this->attaque_speciale=$attaque_speciale;
    }
 {
        $this->nom=$nom;
        $this->vie=$vie;
        $this->niveau_puissabce=$niveau_puissabce;
    }
    
}
class vilains extends Personnage{
    public function __construct($attaque_speciale,$nom,$vie,$niveau_puissabce)
 parent::__construct($N,$Nv,$V)
 {
        $this->nom=$nom;
        $this->attaque_speciale=$attaque_speciale;
    }
 {
        $this->nom=$nom;
        $this->vie=$vie;
        $this->niveau_puissabce=$niveau_puissabce;
    }
    
}