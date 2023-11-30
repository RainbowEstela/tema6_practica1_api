<?php
    namespace TripleTriad;

    require_once './vendor/autoload.php';
    session_start();

    use TripleTriad\controladores\ControladorTripleTriad;
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;
use TripleTriad\vistas\VistaAPICard;

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
            //array con los filtros
            $filtrosArray = [];

            //filtros
            $idInicio="";
            $idFin="";


            //de momento solo vamos a filtar por ids al crear la consulta
            if(isset($_REQUEST["idStart"]) && isset($_REQUEST["idFin"])) {

                $idInicio = $_REQUEST["idStart"];
                $idFin = $_REQUEST["idFin"];

                array_push($filtrosArray,"id_in=".$idInicio."..".$idFin);
            }


            //creamos una cadena con todos los filtros pegados por &
            $filtrosString = implode("&",$filtrosArray);

            $client = new Client();
            $request = $client->request('GET', 'https://triad.raelys.com/api/cards?'.$filtrosString);
            
            $resObj = json_decode($request->getBody());

            VistaAPICard::render($resObj,$idInicio,$idFin);

        }
        
    } else {
        ControladorTripleTriad::menuPrincipal();
    }

?>