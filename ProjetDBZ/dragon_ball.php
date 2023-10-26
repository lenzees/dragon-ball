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
