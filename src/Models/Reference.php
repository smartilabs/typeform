<?php

namespace WATR\Models;

/**
 * Reference Model
 */
class Reference
{
    /**
     * @var string href reference
     */
    public $href;

    public function __construct($object = null)
    {
        if ($object == null) {
            return;
        }
        $this->href = $object->href;
    }
    
    public function setRef($ref) {
        $this->href = $ref;
    }
    
    public function getProcessedHref($prefix = '') 
    {
        $href = $this->href;
        
        if (strpos($href , $prefix) !== false) {
            return $href;
        } 
        
        return $prefix.$href;
    }
}
