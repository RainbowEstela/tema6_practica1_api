<?php

namespace TripleTriad\controladores;

use TripleTriad\modelos\ModeloComentario;
use TripleTriad\vistas\VistaLogin;
use TripleTriad\modelos\ModeloUsuario;
use TripleTriad\vistas\VistaDetalleCarta;
use TripleTriad\vistas\VistaMenuPrincipal;

class ControladorTripleTriad
{

    //muestra la ventana de login
    public static function formLogin()
    {
        VistaLogin::render();
    }

    //muestra el menu principal
    public static function menuPrincipal()
    {
        VistaMenuPrincipal::render();
    }

    //comprueba que los datos de login son correctos
    public static function gestionarLogin($nombre, $password)
    {
        $loginCorrecto = false;

        $usuario = ModeloUsuario::buscarUsuario($nombre);

        if ($usuario != null) {

            if (strcmp($usuario->getPassword(), $password)  == 0) {
                $loginCorrecto = true;
            }
        }

        if ($loginCorrecto == true) {
            $_SESSION["id"] = $usuario->getId();
            $_SESSION["nombre"] = $usuario->getNombre();
            ControladorTripleTriad::menuPrincipal();
        } else {
            VistaLogin::render("DATOS ERRONEOS");
        }
    }

    //borra la sesion
    public static function cerrarSesion()
    {
        session_destroy();

        header("Location: index.php");
        die();
    }

    //muesta una carta en detalle
    public static function mostrarDetalleCarta($resObj, $userName)
    {
        $comentarios = ModeloComentario::getComentarios($resObj->id);

        VistaDetalleCarta::render($resObj, $comentarios, $userName);
    }

    //añade un comentario a la base de datos
    public static function addComentario($comentario)
    {
        ModeloComentario::addComentario($comentario);
    }
}
