<?php

namespace Sid\Forms;

class Form
{
    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $messages = [];



    public function add(Field $field)
    {
        $name = $field->getName();

        $this->fields[$name] = $field;
    }



    public function isValid(array $data) : bool
    {
        $success = true;

        $this->messages = [];

        foreach ($this->fields as $name => $field) {
            if (!isset($data[$name])) {
                $data[$name] = null;
            }

            $success = $field->isValid(
                $data[$name]
            );

            if (!$success) {
                $this->messages[$name] = $field->getMessages();

                break;
            }
        }

        return $success;
    }



    public function getMessages() : array
    {
        return $this->messages;
    }

    public function getMessagesFor(string $name) : array
    {
        if (!isset($this->messages[$name])) {
            return [];
        }

        return $this->messages[$name];
    }
}
