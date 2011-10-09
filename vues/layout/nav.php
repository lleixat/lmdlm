<?php ?>
<nav>
    <a href="accueil.html" class="radius5">Accueil</a>
    <?php
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        echo '<a href="mot_obtenir/le-mot-du-jour.html" class="radius5">Mon MDLM</a>';
    } else {
        echo '<a href="user_inscription.html" class="radius5">Inscription</a>';
    }
    ?>
    <a href="user_listeMembres/la-liste-des-membres.html" class="radius5">Membres</a>
    <a href="user_topScore/user_top-score.html" class="radius5">Top Scores</a>
    <a href="mot_afficher/proposer-mot.html" class="radius5">Proposer mot</a>
    <a href="version.html#reglement" class="radius5">Règlement</a>

    <a href="version.html" class="radius5">Version</a>

    <a href="version.html#todo" class="radius5">To Do</a>

    <?php
    if (User::$rang == 5) {
        echo "<a href='admin_administration.html' class='radius5'>administration</a>";
    }
    ?>
</nav>
