<?php
    namespace TripleTriad;

    require_once './vendor/autoload.php';
    session_start();

    use TripleTriad\controladores\ControladorTripleTriad;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;

    //Autocargar las clases --------------------------
    spl_autoload_register(function ($class) {
        //echo substr($class, strpos($class,"\\")+1);
        $ruta = substr($class, strpos($class,"\\")+1);
        $ruta = str_replace("\\", "/", $ruta);
        include_once "./" . $ruta . ".php"; 
    });

    //Fin Autcargar --
    if(isset($_REQUEST["accion"])) {
        if(strcmp($_REQUEST["accion"],"peticionLogin") == 0) {

            
            $nombre = $_REQUEST["nombre"];
            $password = $_REQUEST["password"];

            ControladorTripleTriad::gestionarLogin($nombre,$password);
            die;
        }

    }

    if(!isset($_SESSION["id"])) {
        ControladorTripleTriad::formLogin();
        die;
    }

    if(isset($_REQUEST["accion"])) {

        if(strcmp($_REQUEST["accion"],"peticionLogin") == 0) {

            
            $nombre = $_REQUEST["nombre"];
            $password = $_REQUEST["password"];

            ControladorTripleTriad::gestionarLogin($nombre,$password);
            die;
        }

        

        if(strcmp($_REQUEST["accion"],"cerrarSesion") == 0) {

            ControladorTripleTriad::cerrarSesion();
            die;
        }

        if(strcmp($_REQUEST["accion"],"llamarAPI") == 0) {

            $client = new Client();
            $request = new Request('GET', 'https://triad.raelys.com/api/cards/240');
            $res = $client->sendAsync($request)->wait();
            echo $res->getBody();

        }
        
    } else {
        ControladorTripleTriad::menuPrincipal();
    }

?>