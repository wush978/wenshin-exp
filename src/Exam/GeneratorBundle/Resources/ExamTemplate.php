<?php
namespace Exam\GeneratorBundle\Resources;

use Exam\GeneratorBundle\Entity\Question;

class ExamTemplate 
{
    static private $html_template = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
	var Result = new Array(%question_size%);
	var Question = new Array(%question_size%);
	var question_index = 0;
	function nextQuestion() {
		is_play = false;
		question_index++;
		document.write(Question[question_index]);
	}
	function saveResult(result) {
		Result[question_index] = result;
		question_index++;
		nextQuestion();
	}
	function retrieveAnswer() {
		var form = document.getElementById("form");
		for (var i = 0;i < form.answer.length;i++) {
			if(form.answer[i].checked) {
				return(form.answer[i].value);
			}
		}
	}
	var is_play = false;
	//%assign_Question%
</script>
</head>
<body onload="">
</body>
</html>    
';      

    static private $question_size = 1;
    
	static private $option_template = '<input type="radio" name="answer" value="%option_title%"/><img src="%img_src%" width="%img_width%" height="%img_height%"/><br/>';

	static private $file_name_template = '%question_title%.html';
	
	static private $body_template = '
%question_description%<br/>
<a id="play" href="#" onclick="play()" style="" >播放</a><br/> 

<form id="form" action="%next_question%.html" method="post"> 
	%options% 
	<input type="button" value="作答" onclick="saveResult(retrieveAnswer())"/> 
</form> 
<script> 
	function play() { 
		if (is_play) { 
			return false; 
		} 
		is_play = true; 
		var node = document.createElement("embed"); 
		node.setAttribute("src","%sound_src%"); 
		node.setAttribute("autostart","TRUE"); 
		node.setAttribute("hidden","TRUE");  
		document.body.appendChild(node); 
		return true; 
	} 
</script>';
	
	private $html = '';
	private $file_name = '';
	private $body = '';
	private $assign_Question = '';
	
	public function __construct(Question $question, Question $question_next = null) {
	    // $this->file_name = str_replace('%question_title%', $question->getTitle(), self::$file_name_template);
	    $this->body = str_replace('%sound_src%', $question->getSound(), self::$body_template);
	    $this->body = str_replace('%question_description%', $question->getDescription(), $this->body);
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
	    $this->assign_Question = 'Question[' . $question->getTitle() . '] = ' . "'" . $this->body . "';" . '
	//%assign_Question%';
	    $this->assign_Question = str_replace("\r\n", " \\ \r\n", $this->assign_Question);
	    self::$question_size++;
	    self::$html_template = str_replace('//%assign_Question%', $this->assign_Question, self::$html_template);
	}
	
	static public function getHtml() {
	    self::$html_template = str_replace('%question_size%', self::$question_size, self::$html_template);
	    return self::$html_template;
	}
	
}