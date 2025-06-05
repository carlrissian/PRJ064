<?php

namespace App\Command;


use Shared\Utils\StructureCreator\StructureCreatorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class StructureCreator extends Command
{

    protected static $defaultName = 'structure-creator';

    /**
     * Define arguments and options
     */
    protected function configure()
    {
        $this->setDescription('Create new structure applying DDD and Hexagonal architecture.');
        $this->addArgument(
            'name',
            InputOption::VALUE_REQUIRED,
            'Name to apply'
        );
        $this->addOption(
            'all',
            null,
            InputOption::VALUE_NONE,
            'Create all structure including folders and files.'
        );

        $this->addOption(
            'create',
            null,
            InputOption::VALUE_NONE,
            'Only use case Create.'
        );

        $this->addOption(
            'store',
            null,
            InputOption::VALUE_NONE,
            'Only use case Store.'
        );

        $this->addOption(
            'edit',
            null,
            InputOption::VALUE_NONE,
            'Only use case Edit.'
        );

        $this->addOption(
            'update',
            null,
            InputOption::VALUE_NONE,
            'Only use case Update.'
        );

        $this->addOption(
            'show',
            null,
            InputOption::VALUE_NONE,
            'Only use case Show.'
        );

        $this->addOption(
            'identifier',
            'i',
            InputOption::VALUE_OPTIONAL,
            'Identifier used: id, code.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $structureCreator = new StructureCreatorCommand($input, $output);
        $structureCreator->execute();
    }
}