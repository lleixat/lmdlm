<div id="user_bar">

    <?php
    // création d'un jeton unique pour proteger le login des bots
    $jeton = md5(sha1(CLE_SHA_PERSO . time() . rand(0, 15)));
    // on le fou en session (coté serveur)
    $_SESSION['jeton'] = $jeton;

    // si la session montre qu'on est loggé alors on cree un objet USER
    // pour pouvoir chopper les infos du gars un peu partout
    // (on déplacera surement cette instanciation plus tard)
    //
    // en fait faut instancier le papa controller par defaut meme pour
    // une page statique, déja ca simplifiera le truc vu que la fonction
    // afficher vue est native dans le controlleur père, ca évitera
    // de refaire la fonction dans le dispatcher (case : statique)
    // on pourra donc a l'interieur meme du controlleur pere
    // creer cet objet user() , ça liberera un peu la vue
    // qui en principe ne doit pas contenir de code, ou très très peu
    // arf les vieilles habitudes... :(
    //
    // ====> priorité vendredi 30

    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        require MODEL . DS . "Model.php";
        require MODEL . DS . "UserModel.php";
        require CORE . DS . "User.php";
        $user = new User($_SESSION['id_user']);
    }

    if (isset($_SESSION['login']) && $_SESSION['login'] === true):
        $lien_page_user = "<a href='user_page-perso/{$user->getId()}/user_page-perso.html' class='ub_liens'>{$user->getUser()}</a>";
        $lien_deco = "<a href='user_deco/accueil.html' class='ub_liens'>deconnexion</a>";
        echo "<p>Connecté en tant que " . $lien_page_user . " {$lien_deco}</p>";
    else:
        ?>

            <form action="user_login/accueil.php" method="post" id="forum_ub">
                <p>
                    <input type="hidden" name="ub_jeton" value="<?php echo $jeton; ?>" />
                    <label for="ub_user">User : </label>
                    <input type="text" name="ub_user" id="ub_user" class="radius5" />
                    <label for="ub_pass">Mdp : </label>
                    <input type="password" name="ub_pass" id="ub_pass" class="radius5" />
                    <input type="submit" value="" id="ub_submit" />
                </p>
            </form>

<?php
endif;
?>
</div>