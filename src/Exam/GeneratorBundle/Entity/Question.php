<?php

namespace Exam\GeneratorBundle\Entity;


class Question
{

    /**
     * 
     * @var string
     */
    protected $title;

    /**
     * 
     * @var string
     */
    protected $description;

    /**
     * 
     * @var Exam\GeneratorBundle\Entity\Option[]
     */
    protected $options = array();

    /**
     * 
     * @var string
     */
    protected $sound;

    public function __construct($question_key, ExamConfig $exam_config) 
    {
        $this->setTitle($question_key);
        $this->setDescription($exam_config->getQuestionAttribute($question_key, "description"));
        $sound_src = $exam_config->getQuestionAttribute($question_key, 'sound_src');
        $sound_src = ExamConfig::checkPath($sound_src);
        $this->setSound($sound_src . $exam_config->getQuestionAttribute($question_key, "sound"));
        foreach( $exam_config->getQuestionAttribute($question_key, "options") as $option_key => $option_value ) 
        {
            array_push($this->options, new Option($option_key, $question_key, $exam_config));    
        }    
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
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param  $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return the string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     */
    public function setSound($sound)
    {
        $this->sound = $sound;
    }

}
