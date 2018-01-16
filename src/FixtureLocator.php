<?php

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\FixtureLocatorInterface;
use Nelmio\Alice\IsAServiceTrait;
use Symfony\Component\Finder\Finder as SymfonyFinder;

class FixtureLocator implements FixtureLocatorInterface {

   use IsAServiceTrait;

   private $fixturesPath;
   private $rootDirs;

   /**
    * @param string $fixturePath Path to which to look for fixtures relative to the XXXXXXXXX directory paths.
    * @param string[] $rootDirs Root directories.
    */
   public function __construct($fixturePath, array $rootDirs) {
      $this->fixturesPath = $fixturePath;
      $this->rootDirs = $rootDirs;
   }

   /**
    * Locates fixture files found inside a folder matching the environment name.
    *
    * For example, if the given fixture path is 'Resources/fixtures', it will try to locate
    * the files in the 'Resources/fixtures/*.yml' for each directory passed.
    *
    * {@inheritdoc}
    */
   public function locateFiles(array $directories) {
      $fixtureFiles = array_merge(...array_map(function ($rootDir) {
         return $this->doLocateFiles($rootDir);
      }, $this->rootDirs), ...array_map(function ($directories) {
         return $this->doLocateFiles($directories);
      }, $directories));
      return $fixtureFiles;
   }

   /**
    * Gets the list of files that can be found in the given path.
    *
    * @param string $path
    * @return string[]
    */
   private function doLocateFiles($path) {
      sprintf('%s/%s', $path, $this->fixturesPath);
      $path = realpath($path);
      if (false === $path || false === file_exists($path)) {
         return [];
      }
      $files = SymfonyFinder::create()->files()->in($path)->depth(0)->name('/.*\.(ya?ml)$/i');
      // this sort helps to set an order with filename ( "001-root-level-fixtures.yml", "002-another-level-fixtures.yml", ... )
      $files = $files->sort(function ($a, $b) {
         return strcasecmp($a, $b);
      });
      $fixtureFiles = [];
      foreach ($files as $file) {
         $fixtureFiles[$file->getRealPath()] = true;
      }
      return array_keys($fixtureFiles);
   }
}