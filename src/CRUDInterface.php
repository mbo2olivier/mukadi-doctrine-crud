<?php
/**
 * Created by PhpStorm.
 * User: Olivier
 * Date: 24/08/2017
 * Time: 20:54
 */

namespace Mukadi\Doctrine\CRUD;


interface CRUDInterface {

    public function create($object);
    public function newObject();
    public function get($id);
    public function getOneBy($criteria = array());
    public function listing($criteria = array());
    public function update($object);
    public function delete($object);
    public function supportsClass($class);
    public function getManagedClass();
}