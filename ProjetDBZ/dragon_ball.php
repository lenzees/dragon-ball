<?php
class Personnage{
    protected $nom;
    protected $niveau_puissance;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $attaque_speciale_disponible;

    public function __construct($A,$N,$D,$V)
    {
        $this->attaque_speciale=$A;
        $this->nom = $N;
        $this->niveau_puissance=1;
        $this->degats=$D;
        $this->vies=$V;
        $this->attaque_speciale_disponible = true;
    }

    public function attaque($cible) {
        // Attaquer la cible
        echo $this->nom." attaque ".$cible->nom." !\n";
        $degats = $this->niveau_puissance * $this->degats;
        $cible->vies -= $degats;
    }

    public function attaque_speciale($cible) {
        // Vérifier si l'attaque spéciale est disponible
        if (!$this->attaque_speciale_disponible) {
            echo "L'attaque spéciale n'est pas disponible pour le moment.\n";
            return;
        }

        // Utiliser l'attaque spéciale
        echo $this->nom." utilise son attaque spéciale sur ".$cible->nom." !\n";
        $degats = $this->niveau_puissance * 30;
        $cible->vies -= $degats;
        $this->attaque_speciale_disponible = false;
    }

    public function recharge_attaque_speciale() {
        // Recharger l'attaque spéciale
        $this->attaque_speciale_disponible = true;
        echo $this->nom." a rechargé son attaque spéciale !\n";
    }
}

class Heros extends Personnage{
    public function __construct($A,$N,$D,$V,$AS)
    {
        parent::__construct($A,$N,$D,$V);
        $this->attaque_speciale = $AS;
    }
}

class Vilains extends Personnage{
    public function __construct($A,$N,$D,$V,$AV)
    {
        parent::__construct($A,$N,$D,$V);
        $this->attaque_speciale = $AV;
    }
}

// Créer des héros et des vilains
$goku = new Heros("Kamehameha", "Son Goku", 35, 300, "Super Kamehameha");
$vegeta = new Heros("Final Flash", "Vegeta", 30, 140, "Big Bang Attack");
$freezer = new Vilains("Death Ball", "Freezer", 40, 275, "Supernova");
$cell = new Vilains("Solar Kamehameha", "Cell", 27, 180, "Perfect Barrier");
$heros = array($goku, $vegeta);
$vilains = array($freezer, $cell);

// Boucle de combat
while (true) {
    // Sélectionner un héros et un vilain aléatoirement
    $attaquant = $heros[array_rand($heros)];
    $cible = $vilains[array_rand($vilains)];

    // Attaquer la cible
    $attaquant->attaque($cible);

    // Vérifier si la cible est morte
    if ($cible->vies <= 0) {
        echo $cible->nom." est mort !\n";
        break;
    }

    // Attaquer avec l'attaque spéciale si elle est disponible
    if ($attaquant->attaque_speciale_disponible) {
        $attaquant->attaque_speciale($cible);
    }

    // Recharger l'attaque spéciale après deux rounds
    if (!$attaquant->attaque_speciale_disponible) {
        $attaquant->recharge_attaque_speciale();
    }

    // Vérifier si l'attaquant est mort
    if ($attaquant->vies <= 0) {
        echo $attaquant->nom." est mort !\n";
        break;
    }
}