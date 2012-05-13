<?php

namespace Exam\GeneratorBundle\Command;

use Doctrine\ORM\EntityManager;

use Exam\GeneratorBundle\Entity\ExamData;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ExamAnalysisCommand extends ContainerAwareCommand {

    /**
     * 
     * Enter description here ...
     * @var EntityManager
     */
    protected $em;
    
    protected function initialize(InputInterface $input, OutputInterface $output) {
        parent::initialize($input, $output);
        $this->em = $this->getContainer()->get('doctrine')->getEntityManager();
    }
    
    protected function configure() {
        $this->setName('exam:analysis')->setDescription('Analyze Result')
        ->addArgument('result-path', InputArgument::REQUIRED,
                            'Where is the result?')
        ->addArgument('version', InputArgument::REQUIRED,
                            'Where is the version of result?')
        ->addArgument('answer-path', InputArgument::REQUIRED,
                            'Where is the answer?')
        ;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result_path = $input->getArgument('result-path');
        $version = $input->getArgument('version');
        $answer_path = $input->getArgument('answer-path');
        $personal_data = new ExamData($result_path, $answer_path, $version);
        $this->em->persist($personal_data);
        $this->em->flush();
    }
        
    
}
