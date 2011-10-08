<?php

class FileController extends Controller {

    function upload_fichier($f, $mime) {

        if ($f['error'] == 0) {
            if (in_array($f['type'], $mime)) {
                if ($f['size'] <= TAILLE_MAX_UPLOAD) {
                    $extension = $this->get_extension($f['name']);
                    $chaineRand = $this->chaine_aleatoire(15);
                    $this->nouveau_nom = $chaineRand . "." . $extension;

                    if (move_uploaded_file($f['tmp_name'], UPLOADS . DS . $this->nouveau_nom)) {
                        return true;
                    } else {
                        // probleme de recuperation du fichier
                        $this->error = "Probleme de finalisation de l'envoi du fichier.";
                        return false;
                    }
                } else {
                    // trop lourd
                    $limite = round((TAILLE_MAX_UPLOAD / 1024 / 1024));
                    $this->error = "Fichier trop lourd (max:{$limite}).";
                    return false;
                }
            } else {
                // mime refusé
                $this->error = "Type de fichier refusé.";
                return false;
            }
        } else {
            // probleme d'upload
            $this->error = "Probleme d'upload.";
            return false;
        }
    }

    function get_extension($fichier) {
        $ext = substr(strtolower(strrchr(basename($fichier), ".")), 1);
        return $ext;
    }

    function chaine_aleatoire($taille) {
        $alphabet = array(
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'k', 'l', 'm', 'n', 'o',
            'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2',
            '3', '4', '5', '6', '7', '8', '9', '-');

        $chaine = "";
        $last_char = "-";

        while (strlen($chaine) < $taille) {
            $num_rand = rand(0, count($alphabet) - 1);
            $char_rand = $alphabet[$num_rand];
            if ($char_rand != $last_char) {
                $chaine .= $char_rand;
            }
            $last_char = $char_rand;
        }

        return $chaine;
    }

    function compresse_image($source, $taille, $destination, $qualite) {
        if (file_exists($source)) {
            if (file_exists($destination)) {
                $infos = getimagesize($source);

                $largeur = $infos[0];
                $hauteur = $infos[1];
                $type = $infos['mime'];

                echo $type;

                $ratio = $largeur / $hauteur;

                if ($ratio > 1) {
                    // paysage
                    $nouv_largeur = $taille;
                    $nouv_hauteur = $taille / $ratio;
                } else {
                    // portrait
                    $nouv_hauteur = $taille;
                    $nouv_largeur = $taille * $ratio;
                }


                ob_start();

                $mini = imagecreatetruecolor($nouv_largeur, $nouv_hauteur);

                switch ($type) {
                    case "image/jpeg":
                        $nouvelle_image = imagecreatefromjpeg($source);
                        break;
                    case "image/png":
                        $nouvelle_image = imagecreatefrompng($source);
                        // fond transparent (pour les png avec transparence)
                        imagesavealpha($mini, true);
                        $trans_color = imagecolorallocatealpha($mini, 0, 0, 0, 127);
                        imagefill($mini, 0, 0, $trans_color);
                        break;
                }

                imagecopyresampled($mini, $nouvelle_image, 0, 0, 0, 0, $nouv_largeur, $nouv_hauteur, $largeur, $hauteur);

                switch ($type) {
                    case "image/jpeg":
                        if (!imagejpeg($mini, $destination . basename($source), $qualite)) {
                            $this->error = "Compression de l'image JPG échouée";
                            return false;
                        }
                        break;
                    case "image/png":
                        if (!imagepng($mini, $destination . basename($source), round($qualite / 10))) {
                            $this->error = "Compression de l'image PNG échouée";
                            return false;
                        }
                        break;
                }
                ob_end_flush();
                imagedestroy($mini);
            } else {
                $this->error = "dossier de destination ({$destination})?";
            }
        } else {
            $this->error = "Désolé je ne trouve pas l'image concernée.";
        }
    }

}

?>
