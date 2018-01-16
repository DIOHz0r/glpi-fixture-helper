<?php

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\DatabaseManagerInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\FileLoaderInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\FixtureLocatorInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\LoaderInterface as Diohz0rLoaderInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\PersisterAwareInterface;
use DIOHz0r\Glpi\Fixtures\Persistence\ItemTypePersister;

class Loader implements Diohz0rLoaderInterface {

   private $fixtureLocator;
   private $purgeLoader;
   private $appendLoader;

   public function __construct(
      FixtureLocatorInterface $fixtureLocator,
      FileLoaderInterface $purgeLoader,
      FileLoaderInterface $appendLoader
   ) {
      if (false === $purgeLoader instanceof PersisterAwareInterface) {
         throw new \InvalidArgumentException(
            sprintf(
               'Expected loader to be an instance of "%s".',
               PersisterAwareInterface::class
            )
         );
      }
      if (false === $appendLoader instanceof PersisterAwareInterface) {
         throw new \InvalidArgumentException(
            sprintf(
               'Expected loader to be an instance of "%s".',
               PersisterAwareInterface::class
            )
         );
      }

      $this->fixtureLocator = $fixtureLocator;
      $this->purgeLoader = $purgeLoader;
      $this->appendLoader = $appendLoader;
   }


   /**
    * Loads the specified fixtures of an application.
    *
    * @param DatabaseManagerInterface $manager Entity Manager used for the loading
    * @param array $directories names in which the fixtures can be found
    * @param bool $append
    * @param bool $purgeWithTruncate
    * @return object[] Loaded objects
    */
   public function load(
      DatabaseManagerInterface $manager,
      array $directories,
      $append,
      $purgeWithTruncate
   ) {
      $fixtureFiles = $this->fixtureLocator->locateFiles($directories);

      $fixtures = $this->loadFixtures($manager, $fixtureFiles, $append, $purgeWithTruncate);

      return $fixtures;
   }

   /**
    * @param DatabaseManagerInterface $manager
    * @param array $files
    * @param boolean $append
    * @param boolean $purgeWithTruncate
    * @return mixed
    */
   private function loadFixtures(
      DatabaseManagerInterface $manager,
      array $files,
      $append,
      $purgeWithTruncate
   ) {
      if ($append && $purgeWithTruncate) {
         throw new \LogicException(
            'Cannot append loaded fixtures and at the same time purge the database. Choose one.'
         );
      }
      $persister = new ItemTypePersister($manager);
      if (true === $append) {
         $loader = $this->appendLoader->withPersister($persister);
         return $loader->load($files);
      }
      $loader = $this->purgeLoader->withPersister($persister);
      $purgeMode = (true === $purgeWithTruncate) ? true : false;
      return $loader->load($files, [], $purgeMode);
   }
}