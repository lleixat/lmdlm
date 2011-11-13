<?php ?>
<nav id="general">
        <?php
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
		echo '<a href="news.html">News</a>';
        echo '<a href="mot_obtenir/le-mot-du-jour.html">Espace perso</a>';
		echo '<a href="user_listeMembres/la-liste-des-membres.html">Membres</a>';
    echo '<a href="user_topScore/user_top-score.html">Top Score</a>';
    echo '<a href="mot_afficher/proposer-mot.html">Proposer</a>';
    } else {
        echo '<a href="user_inscription.html">Inscription</a>';
    }
    ?>



    <?php
    if (User::$rang == 5) {
        echo "<a class='admin' href='admin_administration.html'>Admin</a>";
    }
    ?>
</nav>
