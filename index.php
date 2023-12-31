<?php

namespace TripleTriad;

require_once './vendor/autoload.php';
session_start();

use TripleTriad\controladores\ControladorTripleTriad;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use TripleTriad\modelos\Comentario;
use TripleTriad\vistas\VistaAPICard;
use TripleTriad\vistas\VistaDetalleCarta;

//Autocargar las clases --------------------------
spl_autoload_register(function ($class) {
    //echo substr($class, strpos($class,"\\")+1);
    $ruta = substr($class, strpos($class, "\\") + 1);
    $ruta = str_replace("\\", "/", $ruta);
    include_once "./" . $ruta . ".php";
});

//Fin Autcargar --
if (isset($_REQUEST["accion"])) {
    if (strcmp($_REQUEST["accion"], "peticionLogin") == 0) {


        $nombre = $_REQUEST["nombre"];
        $password = $_REQUEST["password"];

        ControladorTripleTriad::gestionarLogin($nombre, $password);
        die;
    }
}

if (!isset($_SESSION["id"])) {
    ControladorTripleTriad::formLogin();
    die;
}

if (isset($_REQUEST["accion"])) {

    //gestiona el login del usuario
    if (strcmp($_REQUEST["accion"], "peticionLogin") == 0) {


        $nombre = $_REQUEST["nombre"];
        $password = $_REQUEST["password"];

        ControladorTripleTriad::gestionarLogin($nombre, $password);
        die;
    }


    //cierra la sesion del usuario
    if (strcmp($_REQUEST["accion"], "cerrarSesion") == 0) {

        ControladorTripleTriad::cerrarSesion();
        die;
    }

    //devuelve las tarjetas por los parametros pasados
    if (strcmp($_REQUEST["accion"], "llamarAPI") == 0) {
        //array con los filtros
        $filtrosArray = [];



        //filtros
        $idInicio = "";
        $idFin = "";
        $name = "";
        $patch = "";
        $stars = "";

        //opcion de paginacion
        $activarPaginacion = true;


        //comprobar ids
        if (isset($_REQUEST["idStart"]) && isset($_REQUEST["idFin"])) {

            $idInicio = $_REQUEST["idStart"];
            $idFin = $_REQUEST["idFin"];

            array_push($filtrosArray, "id_in=" . $idInicio . ".." . $idFin);
        }


        //comprobar nombre
        if (isset($_REQUEST["name"])) {
            $name = $_REQUEST["name"];
            $activarPaginacion = false;

            array_push($filtrosArray, "name_en_cont=" . $name);
        }

        //comprobar parche
        if (isset($_REQUEST["patch"])) {
            $patch = $_REQUEST["patch"];
            $activarPaginacion = false;

            array_push($filtrosArray, "patch_cont=" . $patch);
        }

        //comprobar estrellas
        if (isset($_REQUEST["stars"])) {
            $stars = $_REQUEST["stars"];
            $activarPaginacion = false;

            array_push($filtrosArray, "stars_eq=" . $stars);
        }



        //creamos una cadena con todos los filtros pegados por &
        $filtrosString = implode("&", $filtrosArray);

        $client = new Client();
        $request = $client->request('GET', 'https://triad.raelys.com/api/cards?' . $filtrosString);

        $resObj = json_decode($request->getBody());

        VistaAPICard::render($resObj, $idInicio, $idFin, $activarPaginacion);
    }

    //muestra una carta en detalle
    if (strcmp($_REQUEST["accion"], "detalleCarta") == 0) {
        $idCarta = "";

        if (isset($_REQUEST["id"])) {
            $idCarta = $_REQUEST["id"];
        }

        $client = new Client();
        $request = $client->request('GET', 'https://triad.raelys.com/api/cards/' . $idCarta);

        $resObj = json_decode($request->getBody());

        ControladorTripleTriad::mostrarDetalleCarta($resObj, $_SESSION["nombre"]);
    }

    //añadir un comentario y mostrar el cambio
    if (strcmp($_REQUEST["accion"], "addComentario") == 0) {
        $nick = $_REQUEST["nick"];
        $idCard = $_REQUEST["idCard"];
        $comentario = $_REQUEST["comentario"];

        $comentarioObject = new Comentario(1, intval($idCard), $nick, $comentario);

        //añadir el nuevo comentario en la bd
        ControladorTripleTriad::addComentario($comentarioObject);


        //llamar de nuevo a pintar el detalle de la carta
        $client = new Client();
        $request = $client->request('GET', 'https://triad.raelys.com/api/cards/' . $idCard);

        $resObj = json_decode($request->getBody());

        ControladorTripleTriad::mostrarDetalleCarta($resObj, $_SESSION["nombre"]);
    }
} else {
    ControladorTripleTriad::menuPrincipal();
}
