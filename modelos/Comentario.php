<?php

namespace TripleTriad\modelos;

class Comentario
{

    private $id;
    private $idCard;
    private $nick;
    private $comentario;

    public function __construct($id = "", $idCard = "", $nick = "", $comentario = "")
    {
        $this->id = $id;
        $this->idCard = $idCard;
        $this->nick = $nick;
        $this->comentario = $comentario;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of idCard
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * Set the value of idCard
     *
     * @return  self
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * Get the value of nick
     */
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set the value of nick
     *
     * @return  self
     */
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get the value of comentario
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set the value of comentario
     *
     * @return  self
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }
}
