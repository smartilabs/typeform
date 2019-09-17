<?php

namespace WATR\Models;

/**
 * FormResponse Model
 */
class FormResponse
{
    /**
     * @var string Response id
     */
    public $response_id;

    /**
     * @var string Form identifier
     */
    public $form_id;

    /**
     * @var string token
     */
    public $token;

    /**
     * @var \DateTime submission date
     */
    public $submitted_at;

    /**
     * @var \DateTime landed date
     */
    public $landed_at;

    /**
     * @var string landing_id
     */
    public $landing_id;

    /**
     * @var Form definition of form
     */
    public $definition;

    /**
     * @var Answer[] $answers
     */
    public $answers = [];

    /**
     * @var array $metadata
     */
    public $metadata = [];

    /**
     * @var array $hidden
     */
    public $hidden = [];

    /**
     * Constructor
     */
    public function __construct($json)
    {
        if (isset($json->form_id)) {
            $this->form_id = $json->form_id;
        }
        $this->token = $json->token;
        $this->response_id = $json->response_id;
        $this->landing_id = $json->landing_id;
        $this->submitted_at = $json->submitted_at ? \DateTime::createFromFormat(
            'Y-m-d\TH:i:s\Z',
            $json->submitted_at
        ) : null;

        // if we get strange old dates, null this value
        if ($this->submitted_at && $this->submitted_at->diff(new \DateTime())->y > 20) {
            $this->submitted_at = null;
        }
        
        $this->landed_at = $json->landed_at ? \DateTime::createFromFormat(
            'Y-m-d\TH:i:s\Z',
            $json->landed_at
            ) : null;
        if (isset($json->definition)) {
            $this->definition = new FormDefinition($json->definition);
        }

        if (isset($json->answers)) {
            foreach ($json->answers as $answer) {
                array_push($this->answers, new Answer($answer));
            }
        }

        if(isset($json->hidden))
        {
            foreach($json->hidden as $key => $val)
            {
                $this->hidden[$key] = $val;
            }
        }

        if(isset($json->metadata))
        {
            foreach($json->metadata as $key => $val)
            {
                $this->metadata[$key] = $val;
            }
        }
    }

    /**
     * Get Answer with definition
     */
    public function getAnswerByRef($ref)
    {
        $field = $this->definition->getFieldByRef($ref);
        $result = null;

        if($ref === -1 || $field === -1){ return -1; }

        foreach($this->answers as $answer)
        {
            if($answer->field_identifier === $field->id)
            {
                $result = $answer;
            }
        }

        return [
            'field' => $field,
            'answer' => $result
        ];
    }

    /**
     * @return string
     */
    public function getResponseId(): string
    {
        return $this->response_id;
    }

    /**
     * @param string $response_id
     * @return FormResponse
     */
    public function setResponseId(string $response_id): FormResponse
    {
        $this->response_id = $response_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->form_id;
    }

    /**
     * @param string $form_id
     * @return FormResponse
     */
    public function setFormId(string $form_id): FormResponse
    {
        $this->form_id = $form_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return FormResponse
     */
    public function setToken(string $token): FormResponse
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSubmittedAt(): ?\DateTime
    {
        return $this->submitted_at;
    }

    /**
     * @param \DateTime|null $submitted_at
     * @return FormResponse
     */
    public function setSubmittedAt(\DateTime $submitted_at = null): FormResponse
    {
        $this->submitted_at = $submitted_at;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLandedAt(): ?\DateTime
    {
        return $this->landed_at;
    }

    /**
     * @param \DateTime|null $landed_at
     * @return FormResponse
     */
    public function setLandedAt(\DateTime $landed_at = null): FormResponse
    {
        $this->landed_at = $landed_at;
        return $this;
    }

    /**
     * @return string
     */
    public function getLandingId(): string
    {
        return $this->landing_id;
    }

    /**
     * @param string $landing_id
     * @return FormResponse
     */
    public function setLandingId(string $landing_id): FormResponse
    {
        $this->landing_id = $landing_id;
        return $this;
    }

    /**
     * @return Form
     */
    public function getDefinition(): Form
    {
        return $this->definition;
    }

    /**
     * @param Form $definition
     * @return FormResponse
     */
    public function setDefinition(Form $definition): FormResponse
    {
        $this->definition = $definition;
        return $this;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param Answer[] $answers
     * @return FormResponse
     */
    public function setAnswers(array $answers): FormResponse
    {
        $this->answers = $answers;
        return $this;
    }

    /**
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     * @return FormResponse
     */
    public function setMetadata(array $metadata): FormResponse
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * @return array
     */
    public function getHidden(): array
    {
        return $this->hidden;
    }

    /**
     * @param array $hidden
     * @return FormResponse
     */
    public function setHidden(array $hidden): FormResponse
    {
        $this->hidden = $hidden;
        return $this;
    }
}
