<?php

namespace WATR\Models;

/**
 * Setting Model
 */
class Setting
{
    /**
     * @var boolean public
     */
    public $is_public;

    /**
     * @var boolean trial
     */
    protected $is_trial;

    /**
     * @var string language
     */
    public $language;

    /**
     * @var string progress_bar
     */
    public $progress_bar;

    /**
     * @var boolean show progress bar
     */
    public $show_progress_bar;

    /**
     * @var boolean show branding
     */
    public $show_typeform_branding;
    
    /**
     * Redirect after form 
     * @var string 
     */
    public $redirect_after_submit_url;
    
    /**
     * @var Meta
     */
    public $meta;

    /**
     * Constructor
     */
    public function __construct($object = null)
    {
        if ($object == null) {
            return;
        }
        
        $this->is_public = $object->is_public;
        $this->is_trial = $object->is_trial;
        $this->language = $object->language;
        $this->progress_bar = $object->progress_bar;
        $this->show_progress_bar = $object->show_progress_bar;
        $this->show_typeform_branding = (boolean) $object->show_typeform_branding;
        
        if(isset($object->redirect_after_submit_url)) {
            $this->redirect_after_submit_url = $object->redirect_after_submit_url;
        }
        
        $this->meta = new Meta($object->meta);
    }
    
    public function toArray()
    {
        $output = [];
        $output['language'] = $this->language;
        $output['is_public'] = $this->is_public;
        $output['progress_bar'] = $this->progress_bar;
        if ($this->show_typeform_branding) {
            $output['show_typeform_branding'] = (boolean)  $this->show_typeform_branding;
        }
        if ($this->redirect_after_submit_url) {
            $output['redirect_after_submit_url'] = $this->redirect_after_submit_url;
        }
        return $output;
        
    }
}
