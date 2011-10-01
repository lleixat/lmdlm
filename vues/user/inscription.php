<?php ?>
<?php ?>
<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">

        <title><?php echo TITLE ?></title>

        <link rel="stylesheet" media="screen" href="css/general.css" />
        <link rel="stylesheet" media="screen" href="css/inscription.css" />
        <link rel="stylesheet" media="screen" href="css/trick.css" />
        <script src="js/jquery-1.6.4.min.js" type="text/javascript"></script>
        <script src="js/jquery.easing.1.3.js" type="text/javascript"></script>
        <script src="js/form_inscription.js" type="text/javascript"></script>

        <meta name="description" content="<?php echo DESCRIPTION ?>">
    </head>
    <body>
        <div id="conteneur" class="ombre10">
            <?php
            require LAYOUT_USER_BAR;
            require LAYOUT_HEADER;
            require LAYOUT_NAV;
            ?>

            <div id="content">
                <h1 class="titre_page">Inscription</h1>

                <p>faudrai essayer de faire un truc qui slide en transversal ca serai joli</p>


                <form action="" id="insc_form">
                    <div id="cadre_etapes" class="radius20">
                        <div id="translider">
                            <div id="insc_step1" class="insc_steps">
                                <h3>Utilisateur - étape 1/4</h3>
                                <p>
                                    <label for="insc_user">Utilisateur</label>
                                    <input type="text" name="insc_user" id="insc_user" />
                                </p>
                                <p>
                                    <label for="insc_pass">Mot de passe</label>
                                    <input type="password" name="insc_pass" id="insc_pass" />
                                </p>
                                <p>
                                    <label for="insc_pass2">Confirmation</label>
                                    <input type="password" name="insc_pass2" id="insc_pass2" />
                                </p>

                                <p>
                                    <label for="insc_user">E-mail</label>
                                    <input type="text" name="insc_mail" id="insc_mail" />
                                </p>
                                <p>
                                    <input type="button" value="" class="insc_btnSuivant" />
                                </p>
                            </div>
                            <div id="insc_step2" class="insc_steps">
                                <h3>Avatar - étape 2/4</h3>
                                <p>
                                    <label for="insc_avatar">Choisissez un avatar</label>
                                    <input type="file" name="insc_avatar" id="insc_avatar" />
                                </p>
                                <p>
                                    <input type="button" value="" class="insc_btnPrecedent" />
                                    <input type="button" value="" class="insc_btnSuivant" />
                                </p>
                            </div>
                            <div id="insc_step3" class="insc_steps">
                                <h3>Etablissement -étape 3/4</h3>
                                <p>
                                    <label for="insc_type_etab">Type d'établissement</label>
                                    <select name="insc_type_etab" id="insc_type_etab">
                                        <option value="4">Faculté</option>
                                        <option value="3">Lycée</option>
                                        <option value="2">Collège</option>
                                        <option value="1">Ecole primaire</option>
                                        <option value="0">Educ spé primates</option>
                                    </select>
                                </p>
                                <p>
                                    <label for="insc_ville_etab">Ville</label>
                                    <input type="text" name="insc_ville_etab" id="insc_ville_etab" />
                                </p>
                                <p>
                                    <label for="insc_promo_etab">Promo</label>
                                    <input type="text" name="insc_promo_etab" id="insc_promo_etab" />
                                </p>

                                <p>
                                    <input type="button" value="" class="insc_btnPrecedent" />
                                    <input type="button" value="" class="insc_btnSuivant" />
                                </p>
                            </div>
                            <div id="insc_step4" class="insc_steps">
                                <h3>Validation - étape finale</h3>
                                <p>ici un captcha a la con</p>
                                <p>
                                    <input type="button" value="" class="insc_btnPrecedent" />
                                    <input type="submit" value="" id="insc_btn_inscription" />
                                </p>
                            </div>
                        </div>
                    </div>

                </form>
            </div>




            <?php
            require LAYOUT_FOOTER;
            ?>
        </div>
    </body>
</html>