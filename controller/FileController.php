<?php

class FileController extends Controller {

    function upload_fichier($f,$mime) {
        
        if($f['error'] == 0){
            if(in_array($f['type'],$mime)){
                if($f['size'] <= TAILLE_MAX_UPLOAD){
                    $extension = $this->get_extension($f['name']);
                    $chaineRand = $this->chaine_aleatoire(15);
                    $this->nouveau_nom = $chaineRand.".".$extension;

                    if(move_uploaded_file($f['tmp_name'], UPLOADS.DS.$this->nouveau_nom)){
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
    
    function chaine_aleatoire($taille){
        $alphabet = array(
            'a','b','c','d','e','f','g','h','i','k','l','m','n','o',
            'p','q','r','s','t','u','v','w','x','y','z','0','1','2',
            '3','4','5','6','7','8','9','-');
        
        $chaine = "";
        $last_char = "-";
        
        while(strlen($chaine) < $taille){
            $num_rand = rand(0,count($alphabet)-1);
            $char_rand = $alphabet[$num_rand];
            if($char_rand != $last_char){
                $chaine .= $char_rand;
            }
            $last_char = $char_rand;
        }
        
        return $chaine;
    }

}

?>
