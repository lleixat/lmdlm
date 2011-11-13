<div id="user_bar">
       <h1><a href="accueil.html">le <b>Mot</b> de la <b>Mort</b></a></h1>
        <ul id="quik">
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="reglement.html">Règlement</a></li>
            <li><a href="version.html">Version</a></li>
            <li><a href="todo.html">Roadmap</a></li>
            <li><a href="about.html">À propos</a></li>
        </ul>

<script type="text/javascript">
$(document).ready(function() {

    $(".con").click(function(e) {
        e.preventDefault();
        $("fieldset#signin_menu").toggle();
        $(".con").toggleClass("menu-open");
    });

    $("fieldset#signin_menu").mouseup(function() {
        return false
    });

    $(document).mouseup(function(e) {
        if($(e.target).parent("a.signin").length==0) {
            $(".con").removeClass("menu-open");
            $("fieldset#signin_menu").hide();
        }
    });            

});
</script>
</script>
    <div id="connect">

        <?php
        $html = "";
        // teste la connection de l'utilisateur
        if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        // si oui on crée un objet user

            $html .= "<p>";
            $html .= "<a href='user_deco/accueil.html' class='ub_deco'>Déco</a> ";
            $html .= "[ <a href='user_pageMembre/".User::$id."/user_".User::$user_url.".html' class='ub_liens'>".User::$user."</a> ]";
            $html .= "</p>";

        } else {

        // L'utilisataur n'est pas connecté

        $jeton = md5(sha1(CLE_SHA_PERSO . time() . rand(0, 15)));
        $_SESSION['jeton'] = $jeton;
        $html .= "<a class='con'>Connexion ↓</a>";
        $html .= "<fieldset id='signin_menu'>";
        $html .= "<form action='user_login/accueil.php' method='post' id='signin'>
            <p>Saisissez vos informations de connexion :</p>
            <p class='field'>
                <input type='hidden' name='ub_jeton' value='{$jeton}' />
                <label for='ub_user'>User : </label><input type='text' name='ub_user' id='ub_user' />
            </p>
            <p class='field'>
                <label for='ub_pass'>Mdp : </label><input type='password' name='ub_pass' id='ub_pass' />
            </p>
            <p class='field button'>
                <input type='submit' value='Valider' id='ub_submit' />
            </p>
            </form>";
        }

        $html .= "</fieldset>";
        echo $html;
        ?>

    </div>    

</div>
