<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 24/08/2017
 * Time: 21:45
 */

namespace Mukadi\Doctrine\CRUD;

use Doctrine\Common\Persistence\ObjectManager;

class CRUD implements CRUDInterface{
    /**
     * @var ObjectManager
     */
    protected $om;
    protected $class;
    /**
     * @var Repository
     */
    protected $repo;

    function __construct(ObjectManager $om,$class)
    {
        $this->om = $om;
        $this->class = $class;
        $this->repo = new Repository($this->om);
    }

    public function newObject()
    {
        return new $this->class();
    }

    public function create($object)
    {
        $this->om->persist($object);
        $this->om->flush();
        return $object;
    }

    public function get($id)
    {
        return $this->om->getRepository($this->class)->find($id);
    }

    public function getOneBy($criteria = array())
    {
        return $this->om->getRepository($this->class)->findOneBy($criteria);
    }

    public function update($object)
    {
        $this->om->persist($object);
        $this->om->flush();
        return $object;
    }

    public function delete($object)
    {
        $this->om->remove($object);
        $this->om->flush();
    }

    public function listing($criteria = array()){
        return $this->repo->from($this->class)->listing($criteria);
    }

    public function supportsClass($class)
    {
        return ($class == $this->class || is_subclass_of($class,$this->class));
    }

    public function getManagedClass()
    {
        return $this->class;
    }


} 