<?php

namespace WATR\Models;

use WATR\Models\FieldProperty;
use WATR\Models\Validation;

/**
 * Field Model
 */
class Field
{
    /**
     * @var string unique identifier
     */
    public $id;

    /**
     * @var string title
     */
    public $title;

    /**
     * @var string reference
     */
    public $ref;

    /**
     * @var FieldProperty 
     */
    public $properties;

    /**
     * @var Validation
     */
    public $validations;

    /**
     * @var string type of field
     */
    public $type;

    /**
     * constructor
     */
    public function __construct($object = null)
    {
        if ($object == null) {
            return;
        }
        
        $this->id = $object->id;
        $this->title = $object->title;
        $this->ref = $object->ref;
        $this->type = $object->type;

        if(isset($object->properties))
        {
            $this->properties = new FieldProperty($object->properties, $this->type == "group");
        }

        if(isset($object->validations))
        {
            $this->validations = new Validation($object->validations);
        }
    }
    
    public function toArray()
    {
        $output = [];
        $output['id'] = $this->id;
        $output['title'] = $this->title;
        $output['ref'] = $this->ref;
        $output['properties'] =  $this->properties->toArray();
            
        $output['type'] = $this->type;
        
        return $output;
    }
}
