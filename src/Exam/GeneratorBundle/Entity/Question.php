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
     * @var Option[]
     */
    protected $options = array();

    /**
     * 
     * @var string
     */
    protected $sound;

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
    public function setSound(string $sound)
    {
        $this->sound = $sound;
    }

}
