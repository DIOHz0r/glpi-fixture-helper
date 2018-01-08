<?php

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\DatabaseManagerInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\FixtureLocatorInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\LoaderInterface;

class Loader implements LoaderInterface {

   private $fixtureLocator;
   private $purgeLoader;

   public function __construct(
      FixtureLocatorInterface $fixtureLocator,
      LoaderInterface $purgeLoader
   ) {
      $this->fixtureLocator = $fixtureLocator;
      $this->purgeLoader = $purgeLoader;
   }


   /**
    * Loads the specified fixtures of an application.
    *
    * @param DatabaseManagerInterface $manager Entity Manager used for the loading
    * @param array $directories names in which the fixtures can be found
    * @param bool $purgeWithTruncate
    * @return object[] Loaded objects
    */
   public function load(DatabaseManagerInterface $manager, array $directories, $purgeWithTruncate) {
      $fixtureFiles = $this->fixtureLocator->locateFiles($directories);

      $fixtures = $this->loadFixtures($this->purgeLoader, $manager, $fixtureFiles,
         $purgeWithTruncate);

      return $fixtures;
   }

   /**
    * @param LoaderInterface $loader
    * @param DatabaseManagerInterface $manager
    * @param array $files
    * @param $purgeWithTruncate
    * @return mixed
    */
   private function loadFixtures(
      $loader,
      DatabaseManagerInterface $manager,
      array $files,
      $purgeWithTruncate
   ) {
      $purgeMode = (true === $purgeWithTruncate) ? true : false;
      return $loader->load($files, [], $purgeMode);
   }
}