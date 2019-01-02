<?php

namespace WATR\Models;

/**
 * Validation Model
 */
class Validation
{
    /**
     * @var boolean required
     */
    public $required = false;

    /**
     * Constructor
     */
    public function __construct($object = null)
    {
        if (isset($object->required)) {
        $this->required = $object->required;
        }
    }
    
    
    public function toArray()
    {
        $output = [];
        $output['required'] = $this->required;
        
        return $output;
    }
    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    
}
