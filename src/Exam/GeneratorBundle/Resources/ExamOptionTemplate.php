<?php
namespace Exam\GeneratorBundle\Resources;

use Exam\GeneratorBundle\Entity\Option;

class ExamOptionTemplate
{
    
    private $option;
    
    public function __construct(Option $option) {
        $this->option = file_get_contents(__DIR__ . '/ExamOptionTemplate.html');
        $this->replaceOption('%option_title%', $option->getTitle());
        $this->replaceOption('%img_src%', $option->getImg());
        $this->replaceOption('%img_width%', $option->getImgWidth());
        $this->replaceOption('%img_height%', $option->getImgWidth());
    }
    
    public function getOption() {
        return $this->option;
    }
    
    private function replaceOption($search, $replace) {
        $this->option = str_replace($search, $replace, $this->option);
    }
    
    public static function renderOption(Option $option) {
        $exam_option_template = new ExamOptionTemplate($option);
        return $exam_option_template->getOption();
    }
    
}