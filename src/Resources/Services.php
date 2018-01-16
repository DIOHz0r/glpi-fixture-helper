<?php

use function DI\object;
use DIOHz0r\Glpi\Fixtures\Command\FixtureLoadCommand;
use DIOHz0r\Glpi\Fixtures\DatabaseManager;
use DIOHz0r\Glpi\Fixtures\FixtureLocator;
use DIOHz0r\Glpi\Fixtures\Interfaces\DatabaseManagerInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\FixtureLocatorInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\LoaderInterface;
use DIOHz0r\Glpi\Fixtures\Loader;

return [
   FixtureLoadCommand::class       => object()
      ->constructorParameter('name', 'glpi:fixtures:load'),
   DatabaseManagerInterface::class => object(DatabaseManager::class),
   LoaderInterface::class          => object(Loader::class),
   FixtureLocatorInterface::class  => object(FixtureLocator::class)
      ->constructorParameter('fixturePath', 'src/DataFixtures')
      ->constructorParameter('rootDirs', []),
];