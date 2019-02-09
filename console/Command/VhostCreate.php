<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleCommand extends Command
{

    protected function configure()
    {
        $this->setName('vhost:create');
        $this->setDescription('Create a new vhost in Nginx');
        $this->addOption(
            'template',
            't',
            InputOption::VALUE_OPTIONAL,
            'Choose a template to use. Generic PHP by default.',
            'php'
        );
        $this->addArgument('filename', InputArgument::REQUIRED, 'vHost Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $template = $input->getArgument('template');
        $filename = $input->getArgument('filename');
        $output = <<<CONF
server {
    server_name $serverName;
    root /workspace/$fileName;
    set \$FASTCGI_PASS '127.0.0.1:90$phpVersion';
    include templates/$template.nginx;
}
CONF;


        $output->writeln(sprintf('Your example argument is: %s', $exampleArg));

        $output->writeln("Current Dir:" . getcwd());
        return 0;
    }
}
