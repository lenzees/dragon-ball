<?php
class Personnage {
    protected $nom;
    protected $niveau_puissance;
    protected $vies;
    protected $attaque_speciale;
    protected $degats;
    protected $inventaire;

    public function __construct($A, $N, $D, $V) {
        $this->attaque_speciale = $A;
        $this->nom = $N;
        $this->niveau_puissance = 1;
        $this->degats = $D;
        $this->vies = $V;
        $this->inventaire = new Inventaire();
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
                return $heros;

            case '2':
            case 'vilains':
                $vilains[] = new Vilains("Death Ball", "Freezer", 40, 275);
                $vilains[] = new Vilains("Solar Kamehameha", "Cell", 27, 180);
                $vilains[] = new Vilains("Planet Burst", "Buu", 34, 160);
                return $vilains;

            default:
                echo "Choix invalide.\n";
                break;
        }
    }

    public function attaquer($adversaire) {
        $degats = $this->degats;

        if ($this instanceof Heros) {
            $choix = strtolower(readline("Voulez-vous utiliser votre attaque spéciale ? (o/n)\n"));

            if ($choix == 'o' && rand(1, 4) == 1) {
                echo "{$this->nom} utilise son attaque spéciale {$this->attaque_speciale} !\n";
                $adversaire->vies = 0;
                return;
            }
        }

        if ($adversaire instanceof Personnage && rand(1, 2) == 1) {
            $degats *= 2;
            echo "{$adversaire->nom} se défend et ne subit que {($degats) / 2} dégâts !\n";
        } else {
            echo "{$this->nom} attaque {$adversaire->nom} !\n";
        }

        $adversaire->vies -= $degats;

        if ($adversaire->vies <= 0) {
            echo "{$adversaire->nom} est mort !\n";
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

class Inventaire {
    protected $objets = array();

    public function ajouter_objet($objet) {
        $this->objets[] = $objet;
    }

    public function supprimer_objet($objet) {
        $index = array_search($objet, $this->objets);

        if ($index !== false) {
            unset($this->objets[$index]);
        }
    }

    public function afficher_inventaire() {
        if (empty($this->objets)) {
            echo "L'inventaire est vide.\n";
        } else {
            echo "Inventaire :\n";

            foreach ($this->objets as $objet) {
                echo "- {$objet}\n";
            }
        }
    }
}

$utilisateur = readline("Entrez votre nom : ");
echo "Bienvenue, {$utilisateur} !\n";

$personnages = array();
$personnages[] = new Personnage(null, null, null, null);
$personnages[] = new Personnage(null, null, null, null);

$personnages[0]->choixCamp();
// $personnages[1]->choixCamp();

$manches = 3;
$rounds = array();

for ($i = 1; $i <= $manches; $i++) {
    echo "Manche {$i} !\n";
    $rounds[$i] = array();
    $rounds[$i]['heros'] = $personnages[0];
    $rounds[$i]['vilains'] = $personnages[1];

    for ($j = 1; $j <= 3; $j++) {
        echo "Round {$j} !\n";
        $attaquant = rand(0, 1);
        $defenseur = $attaquant == 0 ? 1 : 0;

        echo "Que voulez-vous faire ?\n";
        echo "1. Attaquer\n";
        echo "2. Se défendre\n";
        $choix = trim(readline());

        switch ($choix) {
            case '1':
                $rounds[$i][$attaquant]->attaquer($rounds[$i][$defenseur]);
                break;
            case '2':
                $degats = $rounds[$i][$attaquant]->degats / 2;
                echo "{$rounds[$i][$attaquant]->nom} se défend et ne subit que {$degats} dégâts !\n";
                $rounds[$i][$attaquant]->vies -= $degats;

                if ($rounds[$i][$attaquant]->vies <= 0) {
                    echo "{$rounds[$i][$attaquant]->nom} est mort !\n";
                }

                break;
            default:
                echo "Choix invalide.\n";
                break;
        }

        if ($rounds[$i][$defenseur]->vies <= 0) {
            echo "{$rounds[$i][$attaquant]->nom} a gagné le round !\n";
            break;
        }
    }
}

$file = fopen("{$utilisateur}.txt", "w");
fwrite($file, json_encode($rounds));
fclose($file);
echo "Les résultats ont été sauvegardés dans le fichier {$utilisateur}.txt.\n";