<?php

namespace Sid\Forms\Tests\Unit;

use Codeception\TestCase\Test;

use Sid\Forms\Field;
use Sid\Forms\Form;

use Zend\Validator\NotEmpty;

class FormTest extends Test
{
    public function testGetters()
    {
        $form = new Form();

        $field = new Field("thisIsTheName");

        $this->assertEquals(
            [],
            $field->getMessages(
                []
            )
        );
    }

    public function testEmptyForm()
    {
        $form = new Form();

        $this->assertTrue(
            $form->isValid(
                []
            )
        );

        $this->assertEquals(
            [],
            $form->getMessages(
                []
            )
        );

        $this->assertEquals(
            [],
            $form->getMessagesFor("exampleField", null)
        );
    }

    public function testActualForm()
    {
        $form = new Form();

        $field = new Field("exampleField");



        $notEmptyValidator = new NotEmpty();

        $field->addValidator($notEmptyValidator);



        $form->add($field);



        $this->assertTrue(
            $form->isValid(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $this->assertEquals(
            [],
            $form->getMessages(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );



        $this->assertFalse(
            $form->isValid(
                []
            )
        );

        $this->assertEquals(
            [
                "exampleField" => [
                    "isEmpty" => "Value is required and can't be empty"
                ]
            ],
            $form->getMessages(
                []
            )
        );

        $this->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $form->getMessagesFor("exampleField", null)
        );



        $this->assertFalse(
            $form->isValid(
                [
                    "exampleField" => ""
                ]
            )
        );

        $this->assertEquals(
            [
                "exampleField" => [
                    "isEmpty" => "Value is required and can't be empty"
                ]
            ],
            $form->getMessages(
                [
                    "exampleField" => ""
                ]
            )
        );

        $this->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $form->getMessagesFor("exampleField", "")
        );



        $this->assertTrue(
            $form->isValid(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $this->assertEquals(
            [],
            $form->getMessages(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $this->assertEquals(
            [],
            $form->getMessagesFor("exampleField", "This is not empty.")
        );
    }
}
