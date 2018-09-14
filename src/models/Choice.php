<?php

namespace WATR\Models;

/**
 * Choice Model
 */
class Choice
{
    /**
     * @var string unique identifier
     */
    public $id;

    /**
     * @var string reference
     */
    public $ref;

    /**
     * @var string label
     */
    public $label;

    /**
     * constructor
     */
    public function __construct($object = null)
    {
        if ($object == null) {
            return $object;
        }
        if(isset($object->id))
        {
            $this->id = $object->id;
        }
        if(isset($object->ref))
        {
            $this->ref = $object->ref;
        }
        $this->label = $object->label;
    }
    
    public function toArray()
    {
        $output = [];
        
        if ($this->getId() != null) {
            $output['id'] = $this->getId();
        }
            
        if ($this->getRef() != null) {
            $output['ref'] = $this->getRef();
        }
            
        if ($this->getLabel() != null) {
            $output['label'] = $this->getLabel();
        }
            
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
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

}
