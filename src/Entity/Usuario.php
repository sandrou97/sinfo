<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rol;

    public function getUserName(){
        return $this->user;
    }

    public function getPassword(){
       return $this->pass;
    }

    public function getSalt(){
        return null;
    }

    public function getRoles(){
       return array($this->rol);
    }

    public function eraseCredentials(){
    }

    public function serialize(){
        return serialize(array($this->id,$this->user,$this->pass));
    }

    public function unserialize($datos_serializados){
        list($this->id, $this->user, $this->pass) = unserialize($datos_serializados, array('allowed_classes' => false));
    }
}
