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
