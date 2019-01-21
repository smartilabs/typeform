<?php

namespace WATR\Models;

use WATR\Models\Field;
use WATR\Models\Link;
use WATR\Models\Reference;
use WATR\Models\Screen;

/**
 * Form Model
 */
class Form  extends \WATR\Models\Model
{
    
    /**
     *
     * @var string
     */
    public $baseUri = 'forms';
    
    /**
     * @var string Typeform unique identifier
     */
    public $id;

    /**
     * @var string title
     */
    public $title;

    /**
     * @var Reference identifier for location
     */
    public $theme;

    /**
     * @var Reference identifier for location
     */
    public $workspace;

    /**
     * @var Setting Typeform form settings
     */
    public $settings;

    /**
     * @var Screen[] settings
     */
    public $welcome_screens = [];

    /**
     * @var Screen[] settings
     */
    public $thankyou_screens = [];

    /**
     * @var Field[] settings
     */
    public $fields = [];

    /*
     * @var Link settings
     */
    public $link = [];
    
    /*
     * @var '' settings
     */
    public $hidden = [];
    /*
     * @var '' settings
     */
    public $logic = [];

    /**
     * @var raw form
     */
    private $raw;
    
    /**
     * Generates an array of items which will need to be used to send back to typeform
     *
     * @return array
     */
    public function getProperties() {
        
        $out = [];
        $out[] = 'id';
        $out[] = 'title';
        $out[] = ['id' => 'theme', 'type' => 'reference'];
        $out[] = ['id' => 'workspace', 'type' => 'reference'];
        $out[] = ['id' => 'welcome_screens', 'type' => 'array', 'class' => Screen::class];
        $out[] = ['id' => 'thankyou_screens', 'type' => 'array', 'class' => Screen::class];
        $out[] = ['id' => 'fields', 'type' => 'array', 'class' => Field::class];
        $out[] = ['id' => 'logic', 'type' => 'array', 'class' => Field::class];
        $out[] = 'link';
        $out[] = ['id' => 'hidden', 'type' => 'array'];
        
        return $out;
    }
    
    /**
     * Generates a URL to obtain information from
     *
     * @return string
     */
    public function getUrl() {
        return $this->baseUri;
    }
    
    /**
     * Form constructor
     */
    public function __construct($json = null)
    {
        if ($json == null) {
            return;
        }
        
        $this->raw = $json;
        $this->id = $json->id;
        $this->title = $json->title;

        $this->theme = new Reference($json->theme);
        $this->workspace = new Reference($json->workspace);
        $this->settings = new Setting($json->settings);

        if(isset($json->welcome_screens))
        {
            foreach($json->welcome_screens as $screen)
            {
                array_push($this->welcome_screens, new Screen($screen));
            }
        }

        if (isset($json->thankyou_screens)) {
            foreach ($json->thankyou_screens as $screen) {
                array_push($this->thankyou_screens, new Screen($screen));
            }
        }

        $this->settings = new Link($json->_links);
        
        if (isset($json->fields)) {
            foreach ($json->fields as $field) {
                array_push($this->fields, new Field($field));
            }
        }
        if (isset($json->logic)) {
            $this->logic = $json->logic;
        }

        if(isset($json->hidden))
        {
            foreach($json->hidden as $hid)
            {
                array_push($this->hidden, $hid);
            }
        }
        
    }

    /**
     * Add hidden fields
     */
    public function addHiddenFields($fields)
    {
        if(!isset($this->raw->hidden))
        {
            $this->raw->hidden = $fields;
        } else {
            $fields = array_diff($fields, $this->raw->hidden);

            $this->raw->hidden = array_merge($fields, $this->raw->hidden);
        }
    }

    public function toArray()
    {
        $output = [];
        
        $output['title'] = $this->title;
        $output['theme'] = $this->theme;
        $output['settings'] = $this->settings->toArray();
        $output['fields'] = array_map(function($field) {
                                return $field->toArray();
                            } , $this->fields);
            
        $output['logic'] = $this->logic;
        
        $output['thankyou_screens'] = array_map(function($field) {
            return $field->toArray();
        } , $this->thankyou_screens);
        
        return $output;
        
    }
    
    public function getQuestionByRef($ref, $searchByTitleAlso = false) {
        
        foreach ($this->fields as $field) {
            if ($ref == $field->getRef()) {
                return $field;
            }
        }
        foreach ($this->fields as $field) {
            if ($ref == $field->getTitle()) {
                return $field;
            }
        }
        
        return null;
    }
    
    public function getRaw()
    {
        return $this->raw;
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
     * @return \WATR\Models\Reference
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param \WATR\Models\Reference $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return \WATR\Models\Reference
     */
    public function getWorkspace()
    {
        return $this->workspace;
    }

    /**
     * @param \WATR\Models\Reference $workspace
     */
    public function setWorkspace($workspace)
    {
        $this->workspace = $workspace;
    }

    /**
     * @return \WATR\Models\Setting
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param \WATR\Models\Setting $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return multitype:\WATR\Models\Screen 
     */
    public function getWelcome_screens()
    {
        return $this->welcome_screens;
    }

    /**
     * @param multitype:\WATR\Models\Screen  $welcome_screens
     */
    public function setWelcome_screens($welcome_screens)
    {
        $this->welcome_screens = $welcome_screens;
    }

    /**
     * @return multitype:\WATR\Models\Screen 
     */
    public function getThankyou_screens()
    {
        return $this->thankyou_screens;
    }
    
    /**
     * @param multitype:\WATR\Models\Screen  $thankyou_screens
     */
    public function setThankyou_screens($thankyou_screens)
    {
        $this->thankyou_screens = $thankyou_screens;
    }

    /**
     * @return multitype:\WATR\Models\Field 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param multitype:\WATR\Models\Field  $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return multitype:
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param multitype: $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return multitype:
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * @param multitype: $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * @param \WATR\Models\raw $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

}
