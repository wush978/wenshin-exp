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
	function saveResult(result) {
		var location = document.URL;
		location = location.slice(7, location.length - 4);
		location = location.concat("txt");
		var fso = new ActiveXObject("Scripting.FileSystemObject");
		var s = fso.CreateTextFile(location, true);
		s.WriteLine(result);
		s.Close();
		document.getElementById("form").submit();
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
</script>
</head>
<body>
%question_description%<br/>
<a id="play" href="#" onclick="play()" style="" >播放</a><br/>

<form id="form" action="%next_question%.html" method="post">
	%options%
	<input type="button" value="作答" onclick="saveResult(retrieveAnswer())"/>
</form>
<script>
</script>
</body>
</html>    
';      

	static private $option_template = '<input type="radio" name="answer" value="%option_title%"/><img src="%img_src%" width="%img_width%" height="%img_height%"/><br/>';

	static private $file_name_template = '%question_title%.html';
	
	private $html = '';
	private $file_name = '';
	
	public function __construct(Question $question, Question $question_next = null) {
	    $this->file_name = str_replace('%question_title%', $question->getTitle(), self::$file_name_template);
	    $this->html = str_replace('%sound_src%', $question->getSound(), self::$html_template);
	    $this->html = str_replace('%question_description%', $question->getDescription(), $this->html);
	    if (is_null($question_next)) {
	        $this->html = str_replace('%next_question%','final',$this->html);
	    }
	    else {
	        $this->html = str_replace('%next_question%',$question_next->getTitle(),$this->html);
	    }
	    $options = '';
	    foreach($question->getOptions() as $option) {
	        /* @var Option $option */
	        $temp = str_replace('%option_title%', $option->getTitle(), self::$option_template);
	        $temp = str_replace('%img_src%', $option->getImg(), $temp);
	        $temp = str_replace('%img_width%', $option->getImgWidth(), $temp);
	        $temp = str_replace('%img_height%', $option->getImgHeight(), $temp);
	        $options .= $temp;
	    }
	    $this->html = str_replace('%options%', $options, $this->html);
	}
	
	public function export($out_dir) {
	    file_put_contents($out_dir . $this->file_name, $this->html);
	}
	
}