<?php
    /**
     * Resmushit utilise l'api reshmush.it pour optimiser les images de votre site
     * Doit etre placé à l'interieur du repertoire d'images a optimiser
     * Created by Everyways.
     * Date: 6/16/16
     */


    define('WEBSERVICE', 'http://api.resmush.it/ws.php?img=');
    define('DIR_OLD_IMG', 'compressed_files');

    $l_aImgFiles = scandir(getcwd());
    foreach($l_aImgFiles as $l_sImg) {
        if(is_file($l_sImg)) {
            $l_oCompressFile = json_decode(file_get_contents(WEBSERVICE . $l_sImg));
            if(isset($l_oCompressFile->error)){
                die('Fail -> '.$l_oCompressFile->error.' - '.$l_oCompressFile->error_long);
            } else {
                // on a un retour correct
                $l_sCompressImg = file_get_contents($l_oCompressFile->dest);

                if (!file_exists(DIR_OLD_IMG) && !is_dir(DIR_OLD_IMG)) {
                    mkdir(DIR_OLD_IMG);
                }

                if(rename($l_sImg, DIR_OLD_IMG.'/'.$l_sImg)) {
                    if(file_put_contents(basename($l_sImg), $l_sCompressImg)) {
                        unlink($l_sImg);
                    } else {
                        die('Error on file optimisation : '.basename($l_sImg));
                    }
                }

            }
        }
    }