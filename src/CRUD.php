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
    /**
     * @var string
     */
    protected $class;
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repo;

    function __construct(ObjectManager $om,$class)
    {
        $this->om = $om;
        $this->class = $class;
        $this->repo = $this->om->getRepository($class);
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

    public function getQueryBuilder() {
        $qb = $this->om->createQueryBuilder();
        $qb
            ->select('o')
            ->from($this->class, 'o');
        return $qb;
    }

    public function count() {
        $query = sprintf('SELECT COUNT(o) FROM %s o',$this->class);
        return $this->om->createQuery($query)->getSingleScalarResult();
    }

    public function listing($args = array()){
        $qb = $this->getQueryBuilder();

        foreach($args as $key => $val) {
            if($key === "limit") {
                if(isset($val['first'])) {
                    $qb->setFirstResult($val['first']);
                }

                if(isset($val['max'])) {
                    $qb->setMaxResults($val['max']);
                }
            }elseif($key === "orderBy"){
                foreach($args['orderBy'] as $sort => $order) {
                    $qb->addOrderBy(sprintf("o.%s",$sort), $order);
                }
            }elseif($key === 'q'){
                $field = $val['field'];
                $tag = sprintf(":%s",$field);
                $qb
                    ->andWhere(sprintf('o.%s LIKE %s', $field,$tag))
                    ->setParameter($tag,"%".$val['val']."%")
                ;
            }else{
                $tag = sprintf(":%s",$key);
                $qb
                    ->andWhere(sprintf("o.%s = %s",$key,$tag))
                    ->setParameter($tag, $val)
                ;
            }
        }

        return $qb->getQuery()->getResult();
    }

    public function supportsClass($class)
    {
        return ($class == $this->class || is_subclass_of($class,$this->class));
    }

    public function getManagedClass()
    {
        return $this->class;
    }

    public function repo() {
        return $this->repo;
    }


} 