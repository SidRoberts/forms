<?php

namespace Sid\Forms;

class Form
{
    /**
     * @var array
     */
    protected $fields = [];



    public function add(Field $field)
    {
        $name = $field->getName();

        $this->fields[$name] = $field;
    }



    public function isValid(array $data) : bool
    {
        return count($this->getMessages($data)) === 0;
    }



    public function getMessages(array $data) : array
    {
        $messages = [];

        foreach ($this->fields as $name => $field) {
            if (!isset($data[$name])) {
                $data[$name] = null;
            }



            $value = $data[$name];

            $fieldMessages = $this->getMessagesFor($name, $value);

            if ($fieldMessages) {
                $messages[$name] = $fieldMessages;
            }
        }

        return $messages;
    }

    public function getMessagesFor(string $name, $value) : array
    {
        if (!isset($this->fields[$name])) {
            return [];
        }



        $field = $this->fields[$name];

        return $field->getMessages($value);
    }
}
