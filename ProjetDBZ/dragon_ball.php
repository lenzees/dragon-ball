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
    private $nom;

 public function __construct($nom,$vie,$niveau_puissabce)
 parent::__construct($nom,$vie,$niveau_puissabce)
 {
        $this->nom=$nom;
        $this->vie=$vie;
        $this->niveau_puissabce=$niveau_puissabce;
    }
    
}
class vilains extends Personnage{
    
}