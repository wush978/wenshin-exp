<?php

namespace Exam\GeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ExamController extends Controller
{
    /**
     * @Route("/exam")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
