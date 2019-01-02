<?php

namespace WATR\Models;

use WATR\Typeform;
use WATR\Models\Model;

/**
 * Base Model for objects 
 */
abstract class Model
{
    /**
     * 
     * @var TypeForm
     */
    private $application;

    /**
     * 
     * @var string
     */
    public $baseUri = null;
    
    /**
     * Generates an array of items which will need to be used to send back to typeform
     *
     * @return array
     */
    abstract public function getProperties();
    
    /**
     * Generates a URL to obtain information from
     *
     * @return string
     */
    abstract public function getUrl();
    
    /**
     * Gets the property by key
     *  
     * 
     * @param unknown $key
     * @return string[]|NULL
     */
    public function getPropertyByKey($key) {
        $properties = $this->getProperties();
        
        foreach($properties as $property) {
            if ($property == $key) {
                return ['id' => $key, 'type' => 'string'];
            }
            
            if (isset($property['id']) && $property['id'] == $key) {
                return $property;
            }
        }
        
        return null;
    }
    
    public function __construct(Typeform $typeformApplication) {
        $this->application = $typeformApplication;
    }

    /**
     * Uses a raw array from typeform to turn this object into a hydrated object
     * @return unknown
     */
    public function fromArray($rawArray = null) {
        
        if ($rawArray == null) {
            return $this;
        }
        
        foreach ($rawArray as $rawKey=>$rawValue) {
            $property = $this->getPropertyByKey($rawKey);
            if ($property['type'] == 'array' && is_array($rawValue)) {
                foreach($rawValue as $childValue) {
                    array_push($this->$rawKey, new $property['class']($childValue));
                }
            }
            if (property_exists($this, $rawKey)) {
                if ($this->$rawKey instanceof Model) {
                    $this->$rawKey->fromArray($rawValue);
                } else {
                    $this->$rawKey = $rawValue;
                }
            }
        }
        
        return $this;
        
    }
    
    /**
     * Converts this object into an array to send to typeform 
     * Note: uses getProperties to configure it
     * 
     * @return array
     */
    public function toArray() {
        $output = [];
        
        foreach ($this->getProperties() as $k=>$val) {
            $fieldType = 'raw';
            $fieldIdentifier = $val;
            
            if (is_array($val)) {
                if (isset($val['type'])) {
                    $fieldType = $val['type'];
                }
                if (isset($val['id'])) {
                    $fieldIdentifier = $val['id'];
                }
            }
            
            
            if(isset($object->$k)) {
                if ($fieldType == 'reference') {
                    
                }
                    
                if ($object->$k instanceof Model) {
                    $object->$k->toArray();
                } else {
                    $object->$k = $val;
                }
            }
        }
            
        return $output;
    }
}
