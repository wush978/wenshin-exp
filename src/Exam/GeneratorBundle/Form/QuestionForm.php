<?php 

namespace Exam\GeneratorBundle\Form;

use Symfony\Component\Form\FormBuilder;

use Symfony\Component\Form\AbstractType;

class QuestionType extends AbstractType
{
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
    }
    
    public function getName()
    {
        return 'task';
    }
}