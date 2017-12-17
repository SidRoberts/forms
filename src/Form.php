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
            $value = $data[$name] ?? null;

            $fieldMessages = $this->getMessagesFor($name, $value);

            if (count($fieldMessages) > 0) {
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
