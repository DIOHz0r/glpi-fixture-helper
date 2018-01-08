<?php

namespace DIOHz0r\Glpi\Fixtures\Interfaces;

interface LoaderInterface {

   /**
    * Loads the specified fixtures of an application.
    *
    * @param DatabaseManagerInterface $manager Entity Manager used for the loading
    * @param array $directories names in which the fixtures can be found
    * @param bool $purgeWithTruncate
    * @return object[] Loaded objects
    */
   public function load(DatabaseManagerInterface $manager, array $directories, $purgeWithTruncate);
}