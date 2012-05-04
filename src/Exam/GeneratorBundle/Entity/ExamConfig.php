<?php
namespace Exam\GeneratorBundle\Entity;

use Exam\GeneratorBundle\Exception\ExamException;

class ExamConfig
{
    
    /**
     * 
     * @var array
     */
    protected $content = array();
    
    /**
     * 
     * @var Exam\GeneratorBundle\Entity\Question[]
     */
    protected $questions = array();
    
    /**
     * @var string
     */
    static protected $attribute_key = '_attribute';
    
    public function __construct($config_path)
    {
        if (!function_exists('yaml_parse_file')) {
            throw new ExamException("Please install pecl::yaml package");
        }
        $this->content = yaml_parse_file($config_path);
        foreach ($this->content as $question_key => $value) {
            if ($question_key === self::$attribute_key) {
                continue;
            }
            array_push($this->questions, new Question($question_key, $this));
        }
    }
    
    public function getAttributes()
    {
        if (isset($this->content[self::$attribute_key])) {
            return $this->content[self::$attribute_key];
        }
        return null;
    }
    
    public function getAttribute($attribute) {
        $attributes = $this->getAttributes();
        if (is_null($attributes)) {
            return null;
        }
        if (!array_key_exists($attribute, $attributes)) {
            return null;
        }
        return $attributes[$attribute];
    }
    
    public function getQuestionSize() {
        $retval = count($this->content);
        if (array_key_exists(self::$attribute_key, $this->content)) {
            $retval--;
        }
        return $retval;
    }

    public function getQuestion($question_key) {
        if (!array_key_exists($question_key, $this->content)) {
            return null;
        }
        return $this->content[$question_key];
    }
    
    public function getQuestionAttribute($question_key, $attribute) {
        if (!array_key_exists($question_key, $this->content)) {
            return null;
        }
        $question = $this->content[$question_key];
        if (!array_key_exists($attribute, $question)) {
            return $this->getAttribute($attribute);
        }
        return $question[$attribute]; 
    }
    
    public function getOptionAttribute($question_key, $option_key, $attribute) {
        if (!array_key_exists($question_key, $this->content)) {
            return null;
        }
        $question = $this->content[$question_key];
        if (!array_key_exists("options", $question)) {
            return null;
        }
        if (!is_array($question["options"])) {
            return null;
        }
        if (!array_key_exists($option_key, $question["options"])) {
            return null;
        }
        $option = $question["options"][$option_key];
        if (!array_key_exists($attribute, $option)) {
            return $this->getQuestionAttribute($question_key, $attribute);
        }
        return $option[$attribute];
    }
}
