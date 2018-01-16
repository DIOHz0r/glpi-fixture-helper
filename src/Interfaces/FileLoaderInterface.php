<?php

namespace DIOHz0r\Glpi\Fixtures\Interfaces;

use DIOHz0r\Glpi\Fixtures\Persistence\PurgeMode;

interface FileLoaderInterface {

   /**
    * Loads the fixtures files and return the loaded objects.
    *
    * @param string[] $fixturesFiles Path to the fixtures files to loads.
    * @param array $parameters
    * @param array $objects
    * @param PurgeMode|null $purgeMode
    *
    * @return object[]
    */
   public function load(
      array $fixturesFiles,
      array $parameters = [],
      array $objects = [],
      PurgeMode $purgeMode = null
   );
}