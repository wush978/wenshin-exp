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
	var Sound_src = new Array(%question_size%);
	var question_index = 0;
	var question_size = %question_size%;
	alert(question_size);
	function nextQuestion() {
		is_play = false;
		question_index++;
		if (question_index < question_size) {
			document.body.innerHTML = Question[question_index];
		}
		else {
			temp = "";
			for(i = 1;i < question_size;i++) {
				temp = temp + Result[i] + ",";
			}
			document.body.innerHTML = temp;
		}	
	}
	function saveResult(result) {
		if(result) {
    		Result[question_index] = result;
    		nextQuestion();
		}
		else {
			alert("你還沒有做選擇");
		}
	}
	function retrieveAnswer() {
		var form = document.getElementById("form");
		for (var i = 0;i < form.answer.length;i++) {
			if(form.answer[i].checked) {
				return(form.answer[i].value);
			}
		}
	}
	function play() { 
		if (is_play) { 
			return false; 
		} 
		is_play = true; 
		var node = document.createElement("embed"); 
		node.setAttribute("src",Sound_src[question_index]); 
		node.setAttribute("autostart","TRUE"); 
		node.setAttribute("hidden","TRUE");  
		document.body.appendChild(node); 
		return true; 
	} 
	var is_play = false;
	//%assign_Question%
	//%assign_Sound_src%
</script>
</head>
<body onload="nextQuestion()">
</body>
</html>    
';      

    static private $question_size = 1;
    
	static private $option_template = '<input type="radio" name="answer" value="%option_title%"/><img src="%img_src%" width="%img_width%" height="%img_height%"/><br/><hr>';

	static private $file_name_template = '%question_title%.html';
	
	static private $body_template = '
<h1>%question_title%</h1>
%question_description%<br/>
<hr>
<a id="play" href="#" onclick="play()" style="" >播放</a><br/> 
<hr>
<form id="form" action="%next_question%.html" method="post"> 
	%options% 
	<input type="button" value="作答" onclick="saveResult(retrieveAnswer())"/> 
</form>'; 

	
	private $html = '';
	private $file_name = '';
	private $body = '';
	private $assign_Question = '';
	private $sound_src = '';
	
	public function __construct(Question $question, Question $question_next = null) {
	    
	    $this->body = str_replace('%question_title%', $question->getTitle(), self::$body_template);
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
	    $this->assign_Question = 'Question[' . $question->getTitle() . '] = ' . "'" . $this->body . "';";
	    $this->assign_Question = str_replace("\n", "' + \n '", $this->assign_Question);
	    $this->assign_Question .= "\n\t//%assign_Question%\n";
	    self::$html_template = str_replace('//%assign_Question%', $this->assign_Question, self::$html_template);
	    
	    $this->sound_src = 'Sound_src[' . $question->getTitle() . '] = ' . "'" . $question->getSound() . "';\n\t//%assign_Sound_src%\n";
        self::$html_template = str_replace('//%assign_Sound_src%', $this->sound_src, self::$html_template);	     
	    
	    self::$question_size++;
	}
	
	static public function getHtml() {
	    self::$html_template = str_replace('%question_size%', self::$question_size, self::$html_template);
	    return self::$html_template;
	}
	
}