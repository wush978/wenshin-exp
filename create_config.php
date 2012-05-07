<?php

$header = <<<EOF
_attribute:
  img_src: img
  sound_src: sound
  js_src: js
  img_width: "960"
  img_height: "540"
  description: |
    各位小朋友，請你在看完以下兩首樂譜之後，按下播放鍵聆聽耳機中的樂曲。
    在聆聽完樂曲之後，從這兩首樂譜之中選出你所聽到的歌曲。

EOF;
$question_template = <<<EOF
%question_index%:
  sound: %question_index%-%answer_index%mid.MID
  answer: %answer_index%
  options:

EOF;
$option_template = <<<EOF
    %option_index%:
      img: %question_index%-%option_index%pic.jpg
      description: ""

EOF;


function make_seed()
{
  list($usec, $sec) = explode(' ', microtime());
  return (float) $sec + ((float) $usec * 100000);
}
srand(make_seed());
$answer_list = array();
for ($repeat = 1;$repeat <= 40;$repeat++) {
$config = $header;
$answer = '';
for ($question_index = 1;$question_index <= 10;$question_index++)
{
	$answer_index = (string) rand(1, 2);
	$answer .= $answer_index . ",";
    $temp = str_replace("%question_index%", $question_index, $question_template);
    $temp = str_replace("%answer_index%", $answer_index, $temp);
    $config .= $temp;
    for ($option_index = 1;$option_index <= 2;$option_index++) 
    {
        $temp = str_replace("%option_index%", $option_index, $option_template);
        $temp = str_replace("%question_index%", $question_index, $temp);
        $config .= $temp;
    }
}
$hash = md5($answer . "wushsand");
file_put_contents("exam_config/config_" . $hash . ".yml", $config);
$answer_list[$hash] = $answer;
}
print_r($answer_list);
file_put_contents("exam_config/answer.txt", base64_encode(serialize($answer_list)));
?>
