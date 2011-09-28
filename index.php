<?php
$joueurs = array("Adrien", "Thomas", "Arnaud");


$an = date("Y", time());
$numSemaine = date("W", time()); // numero de semaine en cour

$name = $an . DIRECTORY_SEPARATOR . "semaine_" . $numSemaine . ".txt"; // nom du fichier de cette semaine
$texte = ""; // texte a ecrire dans le .txt
$consigne = array(); // qui servira a l'affichage 'public'

if (!file_exists($name)) {

    function renvoie_mot() {
        $liste = array(
            "troubadour", "compote de fraise", "cheminée", "avion de chasse", "obélix", "clavicule",
            "nouvelle calédonie", "apéritif", "genou gauche", "croix rouge", "trisomie",
            "danse classique", "canal+", "rafting", "pythagore", "abreuvoir", "marche arriere",
            "feu orange", "pompe a essence", "cure thermale", "fenetre", "concubin", "sorciere",
            "huile d'olive", "pélican", "ragondin", "boucan", "escargot", "pendule", "amputation",
            "apothéose", "coin coin", "tristesse", "joie", "concupiscence ", "juxtaposition",
            "néologismes", "paparazzi", "belge", "impropriété ", "mandature ", "noob", "vespérales ",
            "diplopie ", "trichotillomanie ", "truisme ", "cacochyme ", "bruxomanie ", "brimborion ",
            "gourgandine ", "épectase ", "ventripotent", "trilobite", "toticolis", "pipistrelle",
            "papyrus", "mimolette", "cucurbitacée", "cacatoes", "baobab", "badaboum", "antiphrase",
            "paréchèmes ", "épanalepses", "ziggourat ", "ubuesque", "ubiquité", "silhouette", "satire",
            "recroqueviller", "potron-minet", "porcelaine", "poltron", "oscar", "opportunisme ",
            "nonchalance", "mousseline", "morbide", "molester", "météore", "malotru", "loufoque",
            "kaléidoscope", "infarctus", "hypocoristique", "hurluberlu", "borborygme", "fruste",
            "entrechat", "échec et mat", "échalote", "diable", "couperose", "coqueluche", "coquelicot",
            "confetti", "cimetière", "concubinage", "chandail", "cerf-volant", "amphigouri",
            "abscons", "docteur maboul", "ceinture", "poulet à la bretonne", "société", "carnaval",
            "langue de boeuf", "saucisson", "cornichon", "vielle chausette", "survetement", "métabolisme",
            "prévention", "pancréas", "crasse", "unijambiste", "guitariste", "antisocial", "tracteur",
            "nationaliste", "camisole", "canapé", "confetti", "échalotte", "gargouille"
        );
        return ucfirst(strtolower($liste[rand(0, count($liste) - 1)]));
    }

    // si le fichier contenant les mots de la semaine n'éxiste pas
    // cela veut dire qu'on doit le créer pour cette semaine
    // donc c'est partit

    foreach ($joueurs as $j) {
        $joueur = ucfirst(trim($j)); // nom du joueur

        do {
            // tant que le mot existe déja pour un autre joueur on ira
            // en chercher un autre avec la fonction.

            $mot = renvoie_mot();
        } while (in_array($mot, $consigne));

        // dans le .txt on va balancer une ligne qui ressemblera a ca :
        // nom1 : mot1 | nom2 : mot2 : billy : machin |
        $texte .= $joueur . " : " . $mot . " |";
        $consigne[$joueur] = $mot;
    }

    $texte = trim($texte, "|"); // (on vire le '|' de la fin)
    $fichier = fopen($name, "w");
    fwrite($fichier, utf8_decode($texte));
    fclose($fichier);

    $note = "<p>Fichier {$name} créé :-)</p>";
} else {
    // si le fichier a déja été créé pour cette semaine
    // on va chopper son contenu
    $fichier = fopen($name, "r");
    $ligne = fgets($fichier);
    fclose($fichier);

    foreach (explode("|", $ligne) as $joueur_mot) {
        // joueurMot ressemble a ca => joueur : mot
        $truc = explode(":", $joueur_mot); // donc on sépare ca
        // et on le place dans le tableau de consigne
        // comme ca => $consigne[prenom] = mot
        $consigne[$truc[0]] = utf8_encode($truc[1]);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <title>LE MOT DE LA MORT</title>

        <link rel="stylesheet" media="screen" href="style.css" />

        <script type="text/javascript" src="script.js"></script>

        <meta name="description" content="On aime pas les descriptions on est des 0uf bordel" />
    </head>
    <body>
        <div id="console" class="ombreRound">
            <img src="logo.png" alt="logo dla muerté" id="logo" />
            <h2>Les mots de la semaine <?php echo $numSemaine; ?> !</h2>
            <p>r00t@D3USTZ[rudaK]$ motdelamort start</p>
            <?php
            echo (isset($note)) ? "<br /><p>{$note}</p>" : ""; // indique la création du fichier de la semaine
            ?>
                        <p>#</p>

            <?php
            $h = ""; // le html a generer
            $p = "<p>#  Le mot que <span>%s</span> doit placer est : <span>%s</span></p>\n"; // le modele de ligne a obtenir
            foreach ($consigne as $joueur => $mot) {
                // pour chaque consigne on balance la ligne dans $h
                $h .= sprintf($p, $joueur, $mot);
            }
            echo $h; // on affiche le html une fois quil est généré completement pour ménager la charge server [^^]
            ?>

            <pre><p>#     ____ ______    ____ _____ ____
#    /  _ Y  __/ \ /Y ___Y__ __Y_   \
#    | | \|  \ | | ||    \ / \  /   /
#    | |_/|  /_| \_/|___ | | | /   /_
#    \____|____\____|____/ \_/ \____/
</p></pre>
            <p>#</p>
            <p># Au boulot <?php echo $_SERVER['REMOTE_ADDR'] ?> ;-)</p>
            <p>#</p>
            <p>r00t@D3USTZ[rudaK]$ Quit</p>
            <p></p>
        </div>
        <?php
        include "projectz.php";
        ?>
        <div style="text-align: center;">-** Propulsé par J00mLaFucKer **-<br /><a href="version.html" style="font-size: 0.7em;">Versions</a></div>

    </body>
    <!--
    huhuhuhuuu kouk kouk kouk huhuhuuuuu
    -->
</html>
