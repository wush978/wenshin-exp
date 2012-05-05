<?php

namespace Exam\GeneratorBundle\Entity;

class Option
{

    /**
     * 
     * @var string
     */
    protected $title = "";

    /**
     * 
     * @var string
     */
    protected $description = "";

    /**
     * 
     * @var string
     */
    protected $img = "";
    
    protected $img_width = "";
    
    protected $img_height = "";

    public function __construct($option_key, $question_key, ExamConfig $exam_config) {
        $this->setTitle($option_key);
        $this->setDescription($exam_config->getOptionAttribute($question_key, $option_key, "description"));
        $img_src = $exam_config->getOptionAttribute($question_key, $option_key, 'img_src');
        $img_src = ExamConfig::checkPath($img_src);
        $this->setImg($img_src . $exam_config->getOptionAttribute($question_key, $option_key, "img"));
        $this->setImgWidth($exam_config->getOptionAttribute($question_key, $option_key, "img_width"));
        $this->setImgHeight($exam_config->getOptionAttribute($question_key, $option_key, "img_height"));
    }
    
    /**
     * @return the string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return the string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return the string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getImgWidth() {
        return $this->img_width;
    }
    
    public function setImgWidth($img_width) {
        $this->img_width = $img_width;
    }
    
    public function getImgHeight() {
        return $this->img_height;
    }
    
    public function setImgHeight($img_height) {
        $this->img_height = $img_height;
    }
}
