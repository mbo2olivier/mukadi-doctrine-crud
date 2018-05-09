<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 27/08/2017
 * Time: 13:54
 */

namespace Mukadi\Doctrine\CRUD;

use Doctrine\Common\Persistence\ObjectManager;

class Repository {

    /**
     * @var ObjectManager
     */
    protected $om;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repo;

    function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->repo = null;
    }

    public function from($class){
        $this->repo = $this->om->getRepository($class);
        return $this;
    }

    public function listing($criteria = array()){
        if(count($criteria) == 0)
            return $this->repo->findAll();

        if(isset($criteria['orderBy'])){
            $order  = $criteria['orderBy'];
            unset($criteria['orderBy']);
        }else
            $order = null;
        if(isset($criteria['limit'])){
            $offset = (isset($criteria['limit']['first']))? $criteria['limit']['first']: null;
            $limit = (isset($criteria['limit']['max']))? $criteria['limit']['max']: null;
            unset($criteria['limit']);
        }else{
            $offset = null;
            $limit = null;
        }
        return $this->repo->findBy($criteria,$order,$limit,$offset);
    }


} 