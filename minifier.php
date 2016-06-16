<?php
    /**
     * Minifier permet de minifier simplement les fichiers css
     * Created by Everyways.
     * Date: 6/16/16
     */

    header( "Content-type: text/css" );

    $l_sInputCss = filter_input(INPUT_GET, 'css', FILTER_SANITIZE_STRING);
    if(!empty($l_sInputCss)) {
        $l_sContent = file_get_contents_utf8( $l_sInputCss );
        echo minify( $l_sContent );
    } else {
        die( 'Fail...' );
    }

    // compression simple du fichier
    function minify( $in_sContentCss ) {
        if(isset($in_sContentCss) && !empty($in_sContentCss)) {

        $in_sContentCss = preg_replace( '#/*.*?*/#s', '', $in_sContentCss );
        $in_sContentCss = preg_replace( '#s+#', ' ', $in_sContentCss );
        $in_sContentCss = str_replace( '; ', ';', $in_sContentCss );
        $in_sContentCss = str_replace( ': ', ':', $in_sContentCss );
        $in_sContentCss = str_replace( ' {', '{', $in_sContentCss );
        $in_sContentCss = str_replace( '{ ', '{', $in_sContentCss );
        $in_sContentCss = str_replace( ', ', ',', $in_sContentCss );
        $in_sContentCss = str_replace( '} ', '}', $in_sContentCss );
        $in_sContentCss = str_replace( ';}', '}', $in_sContentCss );

        return trim( $in_sContentCss );

        } else {
            return null;
        }
    }

    /**
     * Recupere fichier et check encodage -> utf8
     * @param string $in_sFileName
     * @return null|string
     */
    function file_get_contents_utf8($in_sFileName) {
        if(isset($in_sFileName) && !empty($in_sFileName)) {

            $content = file_get_contents($in_sFileName);

            return mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));

        } else {
            return null;
        }
    }