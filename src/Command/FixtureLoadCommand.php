<?php

namespace DIOHz0r\Glpi\Fixtures\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FixtureLoadCommand extends Command {

   protected function configure() {
      $this
         // the name of the command
         ->setName('glpi:fixture:load')
         ->setDefinition([
            new InputOption('--force-with-truncate', 'ft', InputOption::VALUE_NONE, 'Drop all database data and create it as new'),
         ])
         // the short description shown while running
         ->setDescription('Loads fixture data.')
         // the full command description shown when running the command with
         // the "--help" option
         ->setHelp('This command allows you to populate your database...');
   }

   protected function execute(InputInterface $input, OutputInterface $output) {
      // ...
   }

}