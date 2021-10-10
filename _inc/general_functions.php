<?php

/**
 * get segments from url
 * @return false|string[]
 */
function get_segments()
{
    $current_url = 'http' .
        ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ?  's://' : '://' ) .
        $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    $path = trim( parse_url( str_replace( BASE_URL, '', $current_url ), PHP_URL_PATH ), '/' );

    return explode( '/', $path );
}


/**
 * getting segment
 * @param $index
 * @return bool|mixed|string
 */
function segment( $index )
{
    $segments = get_segments();

    return isset( $segments[ $index - 1 ] ) ? $segments[ $index - 1 ] : false;
}

/**
 * logging errors
 * @param $e
 */
function log_errors( $e ) {
    // formatting error log
    $error  = date( 'j M Y, G:i' ) . PHP_EOL;
    $error .= '------------------' . PHP_EOL;
    $error .= $e-> getMessage() . ' in [ '. __FILE__ .' ] on line '. __LINE__  . PHP_EOL . PHP_EOL;

    //if error.log doesnt exist, create, file_append -> nenahradí, pripíše
    file_put_contents( APP_PATH . 'error.log', $error, FILE_APPEND );
}

/**
 * Link to last visited page
 *
 * @return mixed|string
 */
function back_link() {
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    else {
        $previous = "javascript:history.go(-1)";    ;
    }

    return $previous;
}

/**
 * Redirect
 *
 * @param $page
 * @param $msg
 * @param int $status_code
 */
function redirect( $page, $msg = '', $status_code = 302 ) {
    if ( $page == 'back' )
    {
        $location = $_SERVER['HTTP_REFERER'];
    }
    else
    {
        $page = ltrim($page, '/');

        $location = BASE_URL . "$page";
    }

    header("Location: $location", true, $status_code);
    die($msg);
}

