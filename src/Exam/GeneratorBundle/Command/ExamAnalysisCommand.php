<?php

namespace Exam\GeneratorBundle\Command;

use Exam\GeneratorBundle\Entity\PersonalData;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ExamAnalysisCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this->setName('exam:analysis')->setDescription('Analyze Result')
        ->addArgument('result-path', InputArgument::REQUIRED,
                            'Where is the result?')
        ->addArgument('version', InputArgument::REQUIRED,
                            'Where is the version of result?')
        ->addArgument('output-path', InputArgument::REQUIRED,
            				'Where to put the output files?')
        ->addArgument('answer-path', InputArgument::REQUIRED,
                            'Where is the answer?')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result_path = $input->getArgument('result-path');
        $version = $input->getArgument('version');
        $output_path = $input->getArgument('output-path');
        $answer_path = $input->getArgument('answer-path');
        $personal_data = new PersonalData($result_path, $answer_path, $version);
    }
        
    
}
