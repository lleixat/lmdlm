<div id="user_bar">
    <?php
    $html = "";
        // le gars est til connecté
        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
            // oui alors on cree un objet user

            $html .= "<p>Connecté en tant que ";
            $html .= "<a href='user_pageMembre/".User::$id."/user_".User::$user_url.".html' class='ub_liens'>".User::$user."</a> ";
            $html .= "<a href='user_deco/accueil.html' class='ub_liens' style='margin-left:20px'>Deconnexion</a></p>";

        } else{
            // Seulement si le gars n'est pas connecté
            $jeton = md5(sha1(CLE_SHA_PERSO . time() . rand(0, 15)));
            $_SESSION['jeton'] = $jeton;
            $html .=
                "<form action='user_login/accueil.php' method='post' id='forum_ub'>
                    <p>
                        <input type='hidden' name='ub_jeton' value='{$jeton}' />
                        <label for='ub_user'>User : </label>
                        <input type='text' name='ub_user' id='ub_user' class='radius5' />
                        <label for='ub_pass'>Mdp : </label>
                        <input type='password' name='ub_pass' id='ub_pass' class='radius5' />
                        <input type='submit' value='' id='ub_submit' />
                    </p>
                </form>";
        }
        echo $html;
    ?>

</div>