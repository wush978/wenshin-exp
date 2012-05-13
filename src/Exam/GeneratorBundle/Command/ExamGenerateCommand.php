<?php

namespace Exam\GeneratorBundle\Command;

use Exam\GeneratorBundle\Entity\ExamConfig;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ExamGenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('exam:generate')->setDescription('Generate Examination Packages')
                ->addArgument('data-path', InputArgument::REQUIRED,
                        'Where is the data(image and sound files)?')
                ->addArgument('config-path', InputArgument::REQUIRED,
                        'Where is the config files?')
                ->addArgument('output-path', InputArgument::REQUIRED,
        				'Where to put the output files?')
				->addArgument('hash', InputArgument::REQUIRED,
						'What is the hash of the answer?')
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
        $config_path = $input->getArgument('config-path');
        $output_path = $input->getArgument('output-path');
		$hash = $input->getArgument('hash');
        $config = new ExamConfig($data_path, $config_path, $hash);
        $config->render($data_path, $output_path);
    }
}
