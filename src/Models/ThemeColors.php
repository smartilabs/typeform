<?php

namespace WATR\Models;

/**
 * Theme Model
 */
class ThemeColors extends \WATR\Models\Model
{
    /**
     * @var string 
     */
    public $answer;

    /**
     * @var string reference
     */
    public $background;
    
    /**
     * @var string label
     */
    public $button;
    
    /**
     * @var string label
     */
    public $question;
    
    /**
     * constructor
     */
    public function __construct($object = null)
    {
        if ($object != null) {
            $this->fromArray($object);
        }
    }
    
    public function getProperties()
    {
        $out = [];
        $out[] = 'answer';
        $out[] = 'background';
        $out[] = 'button';
        $out[] = 'question';
        
        return $out;
    }
}
