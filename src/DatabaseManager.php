<?php

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\DatabaseManagerInterface;

class DatabaseManager implements DatabaseManagerInterface {
   
   /**
    * Gets the named connection.
    *
    * @param string $name The connection name (null for the default one)
    *
    * @return object
    */
   public function getConnection($name = null) {
      // TODO: Implement getConnection() method.
   }

   /**
    * Gets a named object manager.
    *
    * @param string $name The object manager name (null for the default one)
    *
    * @return \DIOHz0r\Glpi\Fixtures\DatabaseManager
    */
   public function getManager($name = null) {
      // TODO: Implement getManager() method.
   }
}