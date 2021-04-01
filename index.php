<?php

    use App\Autoloader;

    session_start();

    define( 'ROOT', str_replace( 'index.php', '', $_SERVER['SCRIPT_FILENAME'] ) );
    define( 'BASEURL', '/mvc6/' );

    require_once ROOT . 'Autoloader.php';
    Autoloader::register();

    // require_once ROOT . '/controllers/Controller.php';
    // require_once ROOT . '/models/Model.php';

    $params = explode( '/', $_GET['p'] );


    if( '' != $params[0] ) {

        $controller     =   '\\App\\Controllers\\' . ucfirst( $params[0] ) . 'Controller';
        $action         =   empty( $params[1] ) ? 'index' : $params[1];

        // var_dump( $controller );
        // var_dump( $action );

        // require_once ROOT . 'controllers/' . $controller . '.php';

        $controller = new $controller;

        if( method_exists( $controller, $action ) ) {

            unset( $params[0] );
            unset( $params[1] );

            // $controller->$action( $params );
            call_user_func_array( array( $controller, $action ), $params );

        } else {
            http_response_code(404);
            echo 'La page demandée n\'existe pas';
        }
        
    } else {
        
        $controller = new App\Controllers\HomeController();
        $controller->index();

    }
