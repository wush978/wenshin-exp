<?php

$answer_list = array();

for ($i = 0;$i < 1024;$i++) {
    $answer = sprintf('%b', $i);
    $pad_length = 10 - strlen($answer);
    $answer = str_repeat('0', $pad_length) . $answer;
    $answer = str_split($answer);
    $answer = implode(',',$answer);
    $answer .= ',';
    $answer = str_replace('0','2',$answer);
//     die(print_r($answer, true));
    $hash = md5($answer . "wushsand");
    $answer_list[$hash] = $answer;
}

file_put_contents('answer.txt', base64_encode(serialize($answer_list)));
file_put_contents('answer_print.txt', print_r($answer_list, true));