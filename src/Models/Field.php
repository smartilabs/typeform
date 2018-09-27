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
        
        $this->setId($object->id);
        $this->setTitle($object->title);
        $this->setRef($object->ref);
        $this->setType($object->type);

        if(isset($object->properties))
        {
            $properties = new FieldProperty($object->properties, $this->getType() == "group");
            $properties->setActivePropertyFields($this->getType());
            $this->setProperties($properties);
        }

        if(isset($object->validations))
        {
            $this->setValidations(new Validation($object->validations));
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
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
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
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return \WATR\Models\FieldProperty
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param \WATR\Models\FieldProperty $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return \WATR\Models\Validation
     */
    public function getValidations()
    {
        return $this->validations;
    }

    /**
     * @param \WATR\Models\Validation $validations
     */
    public function setValidations($validations)
    {
        $this->validations = $validations;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}
