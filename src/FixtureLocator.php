<?php
/**
 * Created by PhpStorm.
 * User: Domingo Oropeza
 * Date: 08-01-2018
 * Time: 04:25 PM
 */

namespace DIOHz0r\Glpi\Fixtures;

use DIOHz0r\Glpi\Fixtures\Interfaces\FixtureLocatorInterface;
use Nelmio\Alice\IsAServiceTrait;

class FixtureLocator implements FixtureLocatorInterface {

   use IsAServiceTrait;
   private $fixtureLocator;

   public function __construct(FixtureLocatorInterface $fixtureLocator) {
      $this->fixtureLocator = $fixtureLocator;
   }

   /**
    * Locales all the fixture files to load.
    *
    * For example, if the given fixture path is 'Resources/fixtures', it will try to locate
    * the files in the 'Resources/fixtures/*.yml' for each directory passed.
    *
    * @param array $directories name
    * @return string[] Fixtures files paths
    */
   public function locateFiles(array $directories) {
      $fixtureFiles = array_flip($this->fixtureLocator->locateFiles($directories));
      $fixtureFiles = $fixtureFiles + array_flip($this->fixtureLocator->locateFiles($directories));
      return array_keys($fixtureFiles);
   }
}