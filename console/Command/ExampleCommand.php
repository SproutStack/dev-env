<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{

    protected function configure()
    {
        $this->setName('example-command');
        $this->setDescription('This command is an example for testing purpose only');
        $this->addArgument('exampleArg', InputArgument::REQUIRED, 'Required example argument');
    }

    /**
     * Here all logic happens
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exampleArg = $input->getArgument('exampleArg');

        $output->writeln(sprintf('Your example argument is: %s', $exampleArg));

        return 0;
    }
}
