Mukadi Doctrine CRUD
====================

It's simple CRUD Helper for Doctrine Managed entities.

## Installation

Run `php composer.phar require mukadi/doctrine-crud`

## Usage

The Mukadi\Doctrine\CRUD\CRUD` class implements methods for create, update, delete and retreive entity managed by Doctrine. the CRUD class instanciation require an instance of Doctrine Object Manager and FQCN of the entity to handle.

*Methods* | *Description*
--- | ---
constructor(\Doctrine\Common\Persistence\ObjectManager, $class) | create an CRUD new instance
newObject() | create an new instance of type $class passed as parameter in the constructor
create($object) | save $object to the database
get($id) | get entity by id
getOneBy($criteria = array()) | retreive a single entity from some criteria
listing($criteria = array()) | get a set of entity by criteria. the criteria array accept some specials keys: `[orderBy]` (eg: `$crud->listing(['orderBy' => ['time' => 'DESC']])`).for order the result. The `['limit']['first']` specify the first element and the key `['limit']['max']` specify the maximum element to fetch
update($object) | update an enetity
delete($object) | remove an entity from the database
supportsClass($class) | check if a class is handled by the CRUD isntance
getManagedClass() | return the FQCN of the managed entity