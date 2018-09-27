<?php

namespace WATR\Models;

/**
 * ThemeBackground Model
 */
class ThemeBackground extends \WATR\Models\Model
{
    /**
     * @var string
     */
    public $brightness;
    /**
     * @var string
     */
    public $layout;
    /**
     * @var string
     */
    public $href;
    
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
        $out[] = 'brightness';
        $out[] = 'layout';
        $out[] = 'href';
        
        return $out;
    }
}
