<?php

namespace Tests;

use Sid\Forms\Field;
use Sid\Forms\Form;
use Zend\Validator\NotEmpty;

class FormCest
{
    public function getters(UnitTester $I)
    {
        $form = new Form();

        $field = new Field("thisIsTheName");

        $I->assertEquals(
            [],
            $field->getMessages(
                []
            )
        );
    }

    public function emptyForm(UnitTester $I)
    {
        $form = new Form();

        $I->assertTrue(
            $form->isValid(
                []
            )
        );

        $I->assertEquals(
            [],
            $form->getMessages(
                []
            )
        );

        $I->assertEquals(
            [],
            $form->getMessagesFor("exampleField", null)
        );
    }

    public function actualForm(UnitTester $I)
    {
        $form = new Form();

        $field = new Field("exampleField");



        $notEmptyValidator = new NotEmpty();

        $field->addValidator($notEmptyValidator);



        $form->add($field);



        $I->assertTrue(
            $form->isValid(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $I->assertEquals(
            [],
            $form->getMessages(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );



        $I->assertFalse(
            $form->isValid(
                []
            )
        );

        $I->assertEquals(
            [
                "exampleField" => [
                    "isEmpty" => "Value is required and can't be empty"
                ]
            ],
            $form->getMessages(
                []
            )
        );

        $I->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $form->getMessagesFor("exampleField", null)
        );



        $I->assertFalse(
            $form->isValid(
                [
                    "exampleField" => ""
                ]
            )
        );

        $I->assertEquals(
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

        $I->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $form->getMessagesFor("exampleField", "")
        );



        $I->assertTrue(
            $form->isValid(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $I->assertEquals(
            [],
            $form->getMessages(
                [
                    "exampleField" => "This is not empty."
                ]
            )
        );

        $I->assertEquals(
            [],
            $form->getMessagesFor("exampleField", "This is not empty.")
        );
    }
}
