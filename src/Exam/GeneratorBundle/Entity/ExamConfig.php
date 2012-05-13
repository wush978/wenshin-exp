<?php
namespace Exam\GeneratorBundle\Entity;

use Exam\GeneratorBundle\Exception\ExamException;
use Exam\GeneratorBundle\Resources\ExamTemplate;

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
	
	/**
	 * @var string
	 */
	protected $hash = '';
    
    public function __construct($data_path, $config_path, $hash)
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
		$this->hash = $hash;
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
    
    public function getQuestions() {
        return $this->questions;
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
    
    public function render($data_path, $output_path) {
        $data_path = self::checkPath($data_path);
        $output_path = self::checkPath($output_path);
        self::copy_directory($data_path, $output_path);
        $exam_template = new ExamTemplate($this);
        file_put_contents($output_path . 'js/exam.js', $exam_template->getJs());
        file_put_contents($output_path . 'out_' . $this->hash . '.html', $exam_template->getHtml());
    }
    
    private function convert($data_path) {
        $img_convert = $this->getAttribute("img_convert"); 
        if (is_null($img_convert)) {
            return null;
        }
        $src_suffix = $img_convert["src_suffix"];
        $dest_suffix = $img_convert["dest_suffix"];
        $img_src = $this->getAttribute("img_src");
        if (is_null($img_src)) {
            $img_src = "";
        }
        if (strrpos($data_path, '/') + 1 != strlen($data_path)) {
            $data_path .= '/';
        }
        $img_src = $data_path . $img_src;
        $file_lists = scandir($img_src);
        foreach ($file_lists as $file) {
            if (strstr($file, $src_suffix) === false) {
                continue;
            }
            $dest_file = str_replace($src_suffix, $dest_suffix, $file);
            if (file_exists($img_src . '/' . $dest_file)) {
                continue;
            }
            system('convert ' . $img_src . '/' . $file . ' ' . $img_src . '/' . $dest_file);
        }
        die();
    }

    static public function checkPath($path) {
        if (strrpos($path, '/') + 1 != strlen($path)) {
            $path .= '/';
        }
        return $path;
    }
    
    static private function copy_directory( $source, $destination ) {
        if ( is_dir( $source ) ) {
            @mkdir( $destination );
            $directory = dir( $source );
            while ( FALSE !== ( $readdirectory = $directory->read() ) ) {
                if ( $readdirectory == '.' || $readdirectory == '..' ) {
                    continue;
                }
                $PathDir = $source . '/' . $readdirectory;
                if ( is_dir( $PathDir ) ) {
                    ExamConfig::copy_directory( $PathDir, $destination . '/' . $readdirectory );
                    continue;
                }
                copy( $PathDir, $destination . '/' . $readdirectory );
            }
    
            $directory->close();
        }else {
            copy( $source, $destination );
        }
    }
    
    public function getHash() {
        return $this->hash;
    }
}
