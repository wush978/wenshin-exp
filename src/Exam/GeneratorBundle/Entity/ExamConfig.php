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
    
    public function getAttribute()
    {
        if (isset($this->content[self::$attribute_key])) {
            return $this->content[self::$attribute_key];
        }
        return null;
    }
    
    public function getQuestionSize() {
        $retval = count($this->content);
        if (array_key_exists(self::$attribute_key, $this->content)) {
            $retval--;
        }
        return $retval;
    }

}
