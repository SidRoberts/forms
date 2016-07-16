<?php

namespace Sid\Forms;

use Zend\Filter\FilterInterface;

use Zend\Validator\ValidatorInterface;

class Field
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var array
     */
    protected $messages = [];



    public function __construct(string $name)
    {
        $this->name = $name;
    }



    public function getName() : string
    {
        return $this->name;
    }



    public function getFilters() : array
    {
        return $this->filters;
    }

    public function getValidators() : array
    {
        return $this->validators;
    }



    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    public function addValidator(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
    }



    public function getFilteredValue($value)
    {
        // Apply filters to value.
        foreach ($this->filters as $filter) {
            $value = $filter->filter($value);
        }
        
        return $value;
    }



    public function isValid($value) : bool
    {
        $this->messages = [];

        $filteredValue = $this->getFilteredValue($value);

        // Validate filtered value.
        foreach ($this->validators as $validator) {
            $success = $validator->isValid($filteredValue);

            if (!$success) {
                $this->messages = $validator->getMessages();

                break;
            }
        }

        return $success;
    }



    public function getMessages() : array
    {
        return $this->messages;
    }
}
