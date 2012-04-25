<?php

namespace Exam\GeneratorBundle\Command;

use Exam\GeneratorBundle\Entity\ExamConfig;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('exam:generate')->setDescription('Generate Examination Packages')
                ->addArgument('data-path', InputArgument::REQUIRED,
                        'Where is the data(image and sound files)?')
                ->addArgument('config-path', InputArgument::REQUIRED,
                        'Where is the config files?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//         $name = $input->getArgument('name');
//         if ($name) {
//             $text = 'Hello ' . $name;
//         } else {
//             $text = 'Hello';
//         }

//         if ($input->getOption('yell')) {
//             $text = strtoupper($text);
//         }

//         $output->writeln($text);
        $data_path = $input->getArgument('data-path');
        $config = new ExamConfig($input->getArgument('config-path'));
        $output->write(print_r($config, true));
        $output->writeln("==============");
        $output->writeln(print_r($config->getQuestionSize(), true));
        $output->write(print_r($config->getAttribute(), true));
    }
}
