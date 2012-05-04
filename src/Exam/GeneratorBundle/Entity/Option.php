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

    public function __construct($option_key, $question_key, ExamConfig $exam_config) {
        $this->setTitle($option_key);
        $this->setDescription($exam_config->getOptionAttribute($question_key, $option_key, "description"));
        $this->setImg($exam_config->getOptionAttribute($question_key, $option_key, "img"));
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
    public function setTitle(string $title)
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
    public function setDescription(string $description)
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
    public function setImg(string $img)
    {
        $this->img = $img;
    }

}
