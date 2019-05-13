<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassAnalyzer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for getting information about classes: name of the class,
 * type of the class, number of properties and methods
 *
 * Example of usage
 * ./bin/console stat:class-analyzer 'Greeflas\StaticAnalyzer\Analyzer\ClassAuthor'
 *
 *
 */
class ClassAnalyzerStat extends Command
{
    protected function configure()
    {
        $this
            ->setName('stat:class-analyzer')
            ->setDescription('Shows statistic about classes')
            ->addArgument(
                'class-name',
                InputArgument::REQUIRED,
                'Full class name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->getArgument('class-name');
        $classAnalyzer = new ClassAnalyzer($className);
        $finalArray = $classAnalyzer->analyze();

        $output->writeln(\sprintf(
            'Class: %s is %s' . \PHP_EOL
            . 'Properties:' . \PHP_EOL
            . '    public: %s' . \PHP_EOL
            . '    protected: %s' . \PHP_EOL
            . '    private: %s' . \PHP_EOL
            . 'Methods:' . \PHP_EOL
            . '    public: %s' . \PHP_EOL
            . '    protected: %s' . \PHP_EOL
            . '    private: %s',
            $finalArray[0]['class name'],
            $finalArray[0]['class type'][0],
            $finalArray[1]['Properties']['public'],
            $finalArray[1]['Properties']['protected'],
            $finalArray[1]['Properties']['private'],
            $finalArray[1]['Methods']['public'],
            $finalArray[1]['Methods']['protected'],
            $finalArray[1]['Methods']['private']
        ));
    }
}
