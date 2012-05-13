<?php
namespace Exam\GeneratorBundle\Resources;

use Exam\GeneratorBundle\Entity\ExamConfig;

use Exam\GeneratorBundle\Entity\Question;

class ExamTemplate 
{
    
    /**
     * 
     * Final Output
     * @var string
     */
    private $html = '';
    
    /**
     * 
     * Final javascript output;
     * @var string;
     */
    private $js = '';
    
    /**
     * @var ExamConfig
     */
    private $config;
    
    /**
     * 
     * Fixed body template
     * @var string
     */
    private $body_template;
    
    public function __construct(ExamController $config) {
        $this->config = $config;
        $this->html = file_get_contents(__DIR__ . 'ExamTemplate.html');
        $this->js = file_get_contents(__DIR__ . 'js/exam.js');
        $this->modifyJs();
    }
    
    public function getJs() {
        return $this->js;
    }
    
    private function modifyJs() {
        replaceJs('%hash%', $config->getHash());
        replaceJs('%question_size', (string) $this->config->getQuestionSize());
        foreach ($this->config->getQuestions() as $question) {
            $this->assignQuestion($question);
        }
    }
    
    private function replaceJs($search, $replace) {
        $this->js = str_replace($search, $replace, $this->js);
    }
    
    private function assignQuestion(Question $question) {
        $assign_string = 'Question[' . $question->getTitle() . '] = ' . "'" . ExamBodyTemplate::renderBody($question) . "';";
        replaceJs('//%assign_Question%', $assign_string);
    }
}