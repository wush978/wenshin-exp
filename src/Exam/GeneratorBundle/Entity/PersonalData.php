<?php
namespace Exam\GeneratorBundle\Entity;

class PersonalData
{
    private $school;
    private $level;
    private $class_var;
    private $student_id;
    private $sex;
    private $is_learned_music;
    private $start_music_year_old;
    private $how_long_learn_music;
    private $is_join_music_group;
    private $joined_music_group_name;
    private $is_join_music_cram_school;
    private $music_cram_school_name;
    private $music_cram_school_subject;
    private $hash;
    private $answer;
    private $input_text;
    
    public function __construct($file_name, $answer_path, $version) {
        $this->answer = file_get_contents($answer_path);
        $this->answer = unserialize(base64_decode($this->answer));
        switch ($version) {
            case '1' :
                $this->constructPersonalDataV1($file_name);
                break;
        }
    }
    
    private function constructPersonalDataV1($file_name) {
        $this->input_text = file_get_contents($file_name);
        $this->input_text = iconv("big5","UTF-8",$this->input_text);
        $this->parseFileName($file_name);
        $this->sex = $this->parseInfo('2.性別:', '<br/><hr/>');
        $this->is_learned_music = $this->parseInfo('3.', '學過獨奏樂器<br/>');
        $this->start_music_year_old = $this->parseInfo('從', '歲開始,');
        $this->how_long_learn_music = $this->parseInfo('樂器名稱: ' , '<br/>');
        $this->is_join_music_group = $this->parseInfo('4.','參加過或目前正參加學校音樂性社團<br/>');
        $this->joined_music_group_name = $this->parseInfo('名稱:','<br/><hr/>');
        $this->is_join_music_cram_school = $this->parseInfo('5.','<br/>');
        $this->music_cram_school_name = $this->parseInfo('課程名稱: ', '<br/>');
        $this->music_cram_school_subject = $this->parseInfo('家教名稱: ', '<br/><hr/>');
        $this->parseAnswer();
        die(print_r($this, true));
    }
    
    private function parseFileName($file_name) {
        $divide_dir = explode('/', $file_name);
        $file_name = $divide_dir[count($divide_dir) - 1];
        $file_name_info = explode('_', $file_name);
        $this->school = $file_name_info[0];
        $this->level = $file_name_info[1];
        $this->class = $file_name_info[2];
        $this->student_id = $file_name_info[3];
        $this->hash = $file_name_info[4];
        $this->hash = explode('.', $this->hash);
        $this->hash = $this->hash[0];
    }
    
    private function parseInfo($prefix, $suffix) {
        $pattern = '@' . $prefix . '(?P<retval>\w+)' . $suffix . '@uU';
        preg_match($pattern, $this->input_text, $matches);
        return $matches['retval'];
    }
    
    private function parseAnswer() {
        $answer = explode("\r\n", $this->input_text);
        $answer = $answer[0];
        $answer = explode(",", $answer);
        $correct_answer = explode(',',$this->answer[$this->hash]);
        die(print_r($answer, true));
    }
}