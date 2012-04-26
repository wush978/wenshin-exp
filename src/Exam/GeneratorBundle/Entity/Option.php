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
