<?php

namespace DIOHz0r\Glpi\Fixtures\Interfaces;

interface PersisterAwareInterface {

   /**
    * @param PersisterInterface $persister
    *
    * @return static
    */
   public function withPersister(PersisterInterface $persister);
}