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
    protected $entity = array();
    
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
}
