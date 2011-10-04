<?php

class FileController extends Controller {

    function upload_fichier() {

    }

    function upload($fichier, $destination, $tab_mime = false) {

        /**
         *      méthode qui servira a gérer les upload d'images
         *      elle recoit les parametres suivants :
         *
         *      fichier : $_FILES['fichier']
         *      $rep : répertoire de destination
         */

        if ($fichier['error'] == 0) {
            // le fichier est bien uploadé

            if ($fichier['size'] <= MAX_UPLOAD_SIZE) {
                // le fichier n'est pas trop lourd

                $tab_mime = ($tab_mime) ? $tab_mime : array("image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp");

                if (in_array($fichier['type'], $tab_mime)) {
                    // bon format de fichier


                    $extension = $this->get_extension($fichier['name']);
                    $nouveau_nom = $this->rand_chaine(15) . "." . $extension;

                    $destination = ($destination) ? $destination : REP_UPLOAD;

                    if (file_exists($destination) && is_dir($destination)) {
                        // le dossier de destination existe bien

                        if (move_uploaded_file($fichier['tmp_name'], $destination . $nouveau_nom)) {
                            // fichier déplacé correctement
                            $this->nouveau_nom = $nouveau_nom;
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {

        }
    }

    function get_extension($fichier) {
        $ext = substr(strtolower(strrchr(basename($fichier), ".")), 1);
        return $ext;
    }

}

?>
