<?php
namespace Exam\GeneratorBundle\Resources;

use Exam\GeneratorBundle\Entity\Question;

class ExamBodyTemplate
{
    
    private $body;
    
    public function __construct(Question $question) {
        $this->body = file_get_contents(__DIR__ . 'ExamBodyTemplate.html');
        replaceBody('%question_title%',$question->getTitle());
        replaceBody('%question_description%',$question->getDescription());
        replaceBody('%sound_src%',$question->getSound());
        $options_string = '';
        foreach ($question->getOptions() as $option) {
            $options_string .= ExamOptionTemplate::renderOption($option);
        }
        replaceBody('%options%', $options_string);
        replaceBody("\n", "' + \n '");
        $this->body .= "\n\t//%assign_Question%\n";
    }
    
    public function getBody() {
        return $this->body;
    }
    
    private function replaceBody($search, $replace) {
        $this->body = str_replace($search, $replace, $this->body);
    }
    
    static public function renderBody(Question $question) {
        $exam_body_template = new ExamBodyTemplate($question);
        return $exam_body_template->getBody();
    }
}