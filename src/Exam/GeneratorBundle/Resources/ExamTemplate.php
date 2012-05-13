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
    
    public function __construct(ExamConfig $config) {
        $this->config = $config;
        $this->html = file_get_contents(__DIR__ . '/ExamTemplate.html');
        $this->js = file_get_contents(__DIR__ . '/js/exam.js');
        $this->modifyJs();
    }
    
    public function getJs() {
        return $this->js;
    }
    
    public function getHtml() {
        return $this->html;
    }
    
    private function modifyJs() {
        $this->replaceJs('%hash%', $this->config->getHash());
        $this->replaceJs('%question_size%', (string) ($this->config->getQuestionSize() + 1));
        foreach ($this->config->getQuestions() as $question) {
            $this->assignQuestion($question);
        }
        $this->replaceJs('%secret_message%', $this->config->getAttribute('secret_message'));
    }
    
    private function replaceJs($search, $replace) {
        $this->js = str_replace($search, $replace, $this->js);
    }
    
    private function assignQuestion(Question $question) {
        $assign_string = 'Question[' . $question->getTitle() . '] = ' . "'" . ExamBodyTemplate::renderBody($question) . "';";
        $assign_string = str_replace("\n", "' + \n '", $assign_string);
        $assign_string .= "\n\t//%assign_Question%\n"; 
        $this->replaceJs('//%assign_Question%', $assign_string);
    }
}