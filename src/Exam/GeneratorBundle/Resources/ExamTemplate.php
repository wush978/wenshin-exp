<?php
namespace Exam\GeneratorBundle\Resources;

use Exam\GeneratorBundle\Entity\Question;

class ExamTemplate 
{
    private $html_template;       

    private $question_size = 1;
    
	private $option_template;

	private $file_name_template = '%question_title%.html';
	
	private $body_template; 

	
	private $html = '';
	private $file_name = '';
	private $body = '';
	private $assign_Question = '';
	private $sound_src = '';
	
	public function __construct(Question $question, Question $question_next = null) {
	    $this->html_template = file_get_contents(__DIR__ . 'ExamTemplate.html');
	    $this->option_template = file_get_contents(__DIR__ . 'ExamOptionTemplate.html');
	    $this->body = str_replace('%question_title%', $question->getTitle(), file_get_contents(__DIR__ . 'ExamBodyTemplate'));
	    $this->body = str_replace('%question_description%', $question->getDescription(), $this->body);
		$this->body = str_replace('%sound_src%', $question->getSound(), $this->body);
	    $options = '';
	    foreach($question->getOptions() as $option) {
	        /* @var Option $option */
	        $temp = str_replace('%option_title%', $option->getTitle(), self::$option_template);
	        $temp = str_replace('%img_src%', $option->getImg(), $temp);
	        $temp = str_replace('%img_width%', $option->getImgWidth(), $temp);
	        $temp = str_replace('%img_height%', $option->getImgHeight(), $temp);
	        $options .= $temp;
	    }
	    $this->body = str_replace('%options%', $options, $this->body);
	    $this->assign_Question = 'Question[' . $question->getTitle() . '] = ' . "'" . $this->body . "';";
	    $this->assign_Question = str_replace("\n", "' + \n '", $this->assign_Question);
	    $this->assign_Question .= "\n\t//%assign_Question%\n";
	    $this->html_template = str_replace('//%assign_Question%', $this->assign_Question, $this->html_template);
	    
//	    $this->sound_src = 'Sound_src[' . $question->getTitle() . '] = ' . "'" . $question->getSound() . "';\n\t//%assign_Sound_src%\n";
        $this->html_template = str_replace('//%assign_Sound_src%', $this->sound_src, $this->html_template);	     
	    
	    self::$question_size++;
	    
	    
	}
	
	static public function getHtml($hash) {
	    $this->html_template = str_replace('%question_size%', self::$question_size, $this->html_template);
		$this->html_template = str_replace('%hash%', $hash, $this->html_template);
	    return $this->html_template;
	}
	
}