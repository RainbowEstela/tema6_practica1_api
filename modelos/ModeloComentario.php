<?php

namespace TripleTriad\modelos;

use TripleTriad\modelos\ConexionBaseDeDatos;
use TripleTriad\modelos\Comentario;
use \PDO;

class ModeloComentario
{
    public static function getComentarios($idCard)
    {
        $conexionObjet = new ConexionBaseDeDatos();
        $conexion = $conexionObjet->getConexion();

        $valores = $conexion->comentarios->find(["idCard" => intval($idCard)]);

        $comentariosArray = [];



        foreach ($valores as $valor) {

            $comentario = new Comentario($valor["id"], $valor["idCard"], $valor["nick"], $valor["comentario"]);

            array_push($comentariosArray, $comentario);
        }

        $conexionObjet->cerrarConexion();

        return $comentariosArray;
    }


    public static function addComentario($comentario)
    {

        $conexionObjet = new ConexionBaseDeDatos();
        $conexion = $conexionObjet->getConexion();



        //Ordeno por id, y me quedo con el mayor
        $resultadoMayor = $conexion->comentarios->findOne(
            [],
            [
                'sort' => ['id' => -1],
            ]
        );
        if (isset($resultadoMayor))
            $idValue = $resultadoMayor['id'];
        else
            $idValue = 0;

        $consulta = $conexion->comentarios->insertOne([
            'id' => intval($idValue + 1),
            'idCard' => intval($comentario->getIdCard()),
            'nick' => $comentario->getNick(),
            'comentario' => $comentario->getComentario()
        ]);
    }
}
