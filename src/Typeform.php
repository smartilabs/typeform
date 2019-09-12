<?php
namespace WATR;

use GuzzleHttp\Client;
use WATR\Models\Form;
use WATR\Models\FormResponse;
use WATR\Models\WebhookResponse;
use GuzzleHttp\Exception\ClientException;
use WATR\Models\Model;

/**
 * Base Package wrapper for Typeform API
 */
class Typeform
{
    /**
     * @var GuzzleHttp\Client $http
     */
    protected $http;

    /**
     * @var  string Typeform API key
     */
    protected $apiKey;

    /**
     * @var string Typeform base URI
     */
    protected $baseUri = 'https://api.typeform.com/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        
        $this->http = new Client([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]
        ]);
    }

    /**
     * Get form information
     */
    public function getForm($formId)
    {
        $response = $this->http->get("/forms/" . $formId);
        $body = json_decode($response->getBody());
        return new Form($body);
    }

    /**
     * Get form responses
     * 
     * @return FormResponse[]
     */
    public function getResponses($formId)
    {
        $response = $this->http->get("/forms/" . $formId . "/responses?page_size=999");
        $body = json_decode($response->getBody());
        $responses = [];
        if (isset($body->items)) {
            foreach ($body->items as $item) {
                $responses[] = new FormResponse($item);
            }
        }
        return $responses;
    }
    
    
    public function findById(string $modelClassName, $id, $params = [])
    {
        $objectBaseClass = new $modelClassName();
        if (!class_exists($modelClassName, true)) {
            throw new \Exception('Class does not exist');
        }
        
        $objectBaseClass = new $modelClassName();
        
        if (!$objectBaseClass instanceof Model) {
            throw new \Exception('Class is not a Model instance');
        }
        
        
        $response = $this->http->get($objectBaseClass->getUrl().'/'.$id);
        
        $body = json_decode($response->getBody());
        
        /**
         *
         * @var Model $parsedObject
         */
        $parsedObject = new $objectBaseClass();
        $parsedObject->fromArray($body);
        return $parsedObject;
    }
    
    /**
     * Returns a list of models from the server
     * 
     * Valid $params (if applicable):
     * 'page' => integer
     * 'page_size' => number
     * 'search' => string 
     * 
     * @param string $modelClassName
     * @param array $params
     */
    public function getList(string $modelClassName, $params = [])
    {
        if (!class_exists($modelClassName, true)) {
            throw new \Exception('Class does not exist');
        }
        
        $objectBaseClass = new $modelClassName();
        
        if (!$objectBaseClass instanceof Model) {
            throw new \Exception('Class is not a Model instance');
        }
        
        $response = $this->http->get($objectBaseClass->getUrl(), [
            'query' => $params
        ]);
        $body = json_decode($response->getBody());
        
        $parsedObjects = [];
        
        if (isset($body->items)) {
            foreach ($body->items as $item) {
                /**
                 * 
                 * @var Model $parsedObject
                 */
                $parsedObject = new $objectBaseClass();
                $parsedObject->fromArray($item);
                $parsedObjects[] = $parsedObject;
            }
        }
        $body->items = $parsedObjects;
        return $body;
    }
    
    /**
     * Get form information
     *
     * @return Form
     */
    public function postForm(Form $form)
    {
        $formData = $form->toArray();
        $response = $this->http->request('POST', "/forms" , [ 'json' => $formData]);
        
        $body = json_decode($response->getBody());
        
        return $this->getForm($body->id);
    }
    /**
     * Get form information
     *
     * @return Form
     */
    public function updateForm(Form $form)
    {
        $formData = $form->toArray();
        $response = $this->http->request('PUT', "/forms/".$form->id , [ 'json' => $formData]);
        
        $body = json_decode($response->getBody());
        
        return $this->getForm($body->id);
    }
    
    /**
     * Register webhook for form
     */
    public function registerWebhook(Form $form, string $url)
    {
        $response = $this->http->put(
            "/forms/" . $form->id . "/webhooks/response",
            [
                'json' => [
                    'url' => $url,
                    'enabled' => true,
                ]
            ]
            );
        return json_decode($response->getBody());
    }


    public function addHiddenFields(Form $form, $fields)
    {
        $form->addHiddenFields($fields);

        $response = $this->http->put(
            "/forms/" . $form->id,
            [
              'json' => (array) $form->getRaw(),
            ]
        );
    }

    /**
     * Parse incoming webhook
     */
    public static function parseWebhook($json)
    {
        return new WebhookResponse($json);
    }
}
