<?php

namespace DIOHz0r\Glpi\Fixtures\Interfaces;

interface FixtureLocatorInterface {

   /**
    * Locales all the fixture files to load.
    *
    * @param array $directories name
    * @return string[] Fixtures files paths
    */
   public function locateFiles(array $directories);
}