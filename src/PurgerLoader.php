<?php

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\FileLoaderInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\PersisterAwareInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\PersisterInterface;
use DIOHz0r\Glpi\Fixtures\Persistence\PurgeMode;
use Nelmio\Alice\IsAServiceTrait;

class PurgerLoader implements FileLoaderInterface, PersisterAwareInterface {

   use IsAServiceTrait;

   const PURGE_MODE_DELETE = 1;
   const PURGE_MODE_TRUNCATE = 2;
   private static $PURGE_MAPPING;
   private $loader;
   private $purgerFactory;
   private $defaultPurgeMode;

   public function __construct(
      FileLoaderInterface $decoratedLoader,
      PurgerFactory $purgerFactory,
      $defaultPurgeMode
   ) {
      if (null === self::$PURGE_MAPPING) {
         self::$PURGE_MAPPING = [
            'delete'   => PurgeMode::createDeleteMode(),
            'truncate' => PurgeMode::createTruncateMode(),
            'no_purge' => PurgeMode::createNoPurgeMode(),
         ];
      }
      $this->loader = $decoratedLoader;
      $this->purgerFactory = $purgerFactory;
      if (false === in_array($defaultPurgeMode, ['delete', 'truncate', 'no_purge'], true)) {
         throw new \InvalidArgumentException(
            sprintf(
               'Unknown purge mode "%s". Use "delete", "truncate" or "no_purge".',
               $defaultPurgeMode
            )
         );
      }
      $this->defaultPurgeMode = self::$PURGE_MAPPING[$defaultPurgeMode];
   }

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
   ) {
      if (null === $purgeMode) {
         $purgeMode = $this->defaultPurgeMode;
      }
      if ($purgeMode != PurgeMode::createNoPurgeMode()) {
         $purger = $this->purgerFactory->create($purgeMode);
         $purger->purge();
      }
      return $this->loader->load($fixturesFiles, $parameters, $objects, $purgeMode);
   }

   /**
    * @inheritdoc
    */
   public function withPersister(PersisterInterface $persister) {
      $defaultPurgeMode = 'no_purge';
      $loader = $this->loader;
      if ($loader instanceof PersisterAwareInterface) {
         $loader = $loader->withPersister($persister);
      }
      foreach (self::$PURGE_MAPPING as $string => $mode) {
         if ($mode == $this->defaultPurgeMode) {
            $defaultPurgeMode = $string;
            break;
         }
      }
      return new self($loader, $this->purgerFactory, $defaultPurgeMode);
   }
}