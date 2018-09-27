<?php

namespace WATR\Models;

/**
 * Theme Model
 */
class Theme extends \WATR\Models\Model
{
    
    /**
     * 
     * @var string
     */
    public $baseUri = 'themes'; 
    
    /**
     * @var string unique identifier
     */
    public $id;

    /**
     * @var string reference
     */
    public $name;
    
    /**
     * @var string 
     */
    public $visibility;
    
    /**
     * @var boolean 
     */
    public $has_transparent_button;
    
    /**
     * @var string 
     */
    public $font;
    
    /**
     * @var ThemeColors
     */
    public $colors;
    
    /**
     * @var ThemeBackground
     */
    public $background;
    
    
    /**
     * constructor
     */
    public function __construct($object = null)
    {
        if ($object == null) {
            return $object;
        }
        
        $this->colors = new ThemeColors();
        $this->background = new ThemeBackground();
        
        $this->fromArray($object);
    }
    
    
    public function getProperties() {
        $out = [];
        $out[] = 'id';
        $out[] = 'name';
        $out[] = 'visibility';
        $out[] = 'has_transparent_button';
        $out[] = 'font';
        $out[] = 'colors';
        
        return $out;
    }
    
    public function getUrl() {
        return $this->baseUri;
    }
    
}
