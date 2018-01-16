<?php

namespace DIOHz0r\Glpi\Fixtures\Persistence;

use DIOHz0r\Glpi\Fixtures\Interfaces\PersisterInterface;
use Nelmio\Alice\IsAServiceTrait;

class ItemTypePersister implements PersisterInterface{

   use IsAServiceTrait;

   private $objectManager;

   public function __construct($manager)
   {
      $this->objectManager = $manager;
   }

   /**
    * Persists objects into the database.
    *
    * @param object $object
    */
   public function persist($object) {
      // TODO: Implement persist() method.
   }

   public function flush() {
      // TODO: Implement flush() method.
   }
}