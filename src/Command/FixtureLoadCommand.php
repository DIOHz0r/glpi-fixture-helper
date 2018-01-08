<?php

namespace DIOHz0r\Glpi\Fixtures\Command;

use DIOHz0r\Glpi\Fixtures\Interfaces\DatabaseManagerInterface;
use DIOHz0r\Glpi\Fixtures\Interfaces\LoaderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class FixtureLoadCommand extends Command {

   /**
    * @var DatabaseManagerInterface
    */
   private $manager;

   /**
    * @var LoaderInterface
    */
   private $loader;

   /**
    * FixtureLoadCommand constructor.
    * @param $name
    * @param DatabaseManagerInterface $manager
    * @param LoaderInterface $loader
    */
   public function __construct($name, DatabaseManagerInterface $manager, LoaderInterface $loader) {
      parent::__construct($name);

      $this->manager = $manager;
      $this->loader = $loader;
   }

   protected function configure() {
      $this
         // the name of the command
         ->setAliases(['glpi:fixture:load'])
         // the short description shown while running
         ->setDescription('Loads fixture data.')
         ->addOption('directory', 'd', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
            'Directories where fixtures should be loaded.'
         )
         ->addOption('purge-with-truncate', 'pt', InputOption::VALUE_NONE,
            'Drop all database data and create it as new')
         // the full command description shown when running the command with
         // the "--help" option
         ->setHelp('This command allows you to populate your database.');
   }

   /**
    * Prompts to the user a message to ask him a confirmation.
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @param string $question
    * @param bool $default
    *
    * @return bool User choice
    */
   private function askConfirmation(
      InputInterface $input,
      OutputInterface $output,
      $question,
      $default
   ) {
      $questionHelper = $this->getHelperSet()->get('question');
      $question = new ConfirmationQuestion($question, $default);
      return (bool) $questionHelper->ask($input, $output, $question);
   }

   protected function execute(InputInterface $input, OutputInterface $output) {
      // Warn the user that the database will be purged
      if ($input->isInteractive() && !$input->getOption('purge-with-truncate')) {
         if (false === $this->askConfirmation(
               $input,
               $output,
               '<question>Careful, database will be purged. Do you want to continue y/N ?</question>',
               false
            )
         ) {
            return 0;
         }
      }

      $output->writeln('Data is been loading onto database, please wait.');

      $manager = $this->manager;
      $directories = $input->getOption('directories');
      $truncate = $input->getOption('purge-with-truncate');

      $this->loader->load($manager, $directories, $truncate);

      $output->writeln('Load success.');

      return 0;
   }

}