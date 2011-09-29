<?php
// création d'un jeton unique pour proteger le login des bots
$jeton = md5(sha1("carnaval".time().rand(0,15)));
// on le fou en session (coté serveur)
$_SESSION['jeton'] = $jeton;
?>
<div id="user_bar">
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
</div>