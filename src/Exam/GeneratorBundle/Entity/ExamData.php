<?php
namespace Exam\GeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ExamData")
 */
class ExamData
{
    /**
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $school;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $level;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $class_var;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $student_id;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $sex;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $is_learned_music;
    
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $start_music_year_old;
    
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $music_subject;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $how_long_learn_music;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $is_join_music_group;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $joined_music_group_name;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $is_join_music_cram_school;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $music_cram_school_name;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $music_cram_school_subject;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $hash;

    private $answer;
    
    /**
     * 
     * @ORM\Column(length=64)
     * @var unknown_type
     */
    private $student_answer;
    
    private $input_text;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q1;

    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q2;

    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q3;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q4;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q5;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q6;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q7;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q8;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q9;
    
    /**
     * 
     * @ORM\Column(type="boolean")
     * @var unknown_type
     */
    private $Q10;
    
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
        $this->sex = $this->parseInfo('2\.性別:', '<br/><hr/>');
        $this->is_learned_music = $this->parseInfo('<br/><hr/>3\.', '學過獨奏樂器<br/>');
        $this->start_music_year_old = $this->parseInfo('從', '歲開始,');
        $this->music_subject = $this->parseInfo('樂器名稱: ' , '<br/>');
        $this->how_long_learn_music = $this->parseInfo('學了', '年<br/><hr/>');
        $this->is_join_music_group = $this->parseInfo('年<br/><hr/>4\.','參加過或目前正參加學校音樂性社團<br/>');
        $this->joined_music_group_name = $this->parseInfo('參加過或目前正參加學校音樂性社團<br/>名稱:','<br/><hr/>');
        $this->is_join_music_cram_school = $this->parseInfo('<br/><hr/>5\.','<br/>');
        $this->music_cram_school_name = $this->parseInfo('課程名稱: ', '<br/>');
        $this->music_cram_school_subject = $this->parseInfo('家教名稱: ', '<br/><hr/>');
        $this->parseAnswer();
    }
    
    private function parseFileName($file_name) {
        $divide_dir = explode('/', $file_name);
        $file_name = $divide_dir[count($divide_dir) - 1];
        $file_name_info = explode('_', $file_name);
        $this->school = $file_name_info[0];
        $this->level = $file_name_info[1];
        $this->class_var = $file_name_info[2];
        $this->student_id = $file_name_info[3];
        $this->hash = $file_name_info[4];
        $this->hash = explode('.', $this->hash);
        $this->hash = $this->hash[0];
    }
    
    private function parseInfo($prefix, $suffix) {
        $pattern = '@' . $prefix . '(?P<retval>.*)' . $suffix . '@uU';
        preg_match($pattern, $this->input_text, $matches);
        if (array_key_exists('retval', $matches)) {
            return $matches['retval'];
        }
        else {
            print_r($prefix);
            print_r($suffix);
            die(print_r($matches, true));
        }
    }
    
    private function parseAnswer() {
        $answer = explode("\r\n", $this->input_text);
        $answer = $answer[0];
        $this->student_answer = $answer;
        $answer = explode(",", $answer);
        $correct_answer = explode(',',$this->answer[$this->hash]);
        for ($i = 0;$i < 10;$i++) {
            $label = 'Q' . ($i + 1);
            if ($answer[$i] === $correct_answer[$i]) {
                $this->$label = true;
            } 
            else {
                $this->$label = false;
            }
        }
    }
    
    
}