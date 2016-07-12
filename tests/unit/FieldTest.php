<?php

namespace Sid\Forms\Tests\Unit;

class FieldTest extends \Codeception\TestCase\Test
{
    public function testGetters()
    {
        $field = new \Sid\Forms\Field("thisIsTheName");

        $this->assertEquals(
            "thisIsTheName",
            $field->getName()
        );

        $this->assertEquals(
            [],
            $field->getFilters()
        );

        $this->assertEquals(
            [],
            $field->getValidators()
        );

        $this->assertEquals(
            [],
            $field->getMessages()
        );
    }

    public function testFilter()
    {
        $field = new \Sid\Forms\Field("thisIsTheName");


        $dashToCamelCaseFilter = new \Zend\Filter\Word\DashToCamelCase();

        $field->addFilter($dashToCamelCaseFilter);




        $regularExpressionValidator = new \Zend\Validator\Regex(
            "/^[A-Za-z]+$/"
        );

        $field->addValidator($regularExpressionValidator);



        $this->assertEquals(
            [
                $dashToCamelCaseFilter
            ],
            $field->getFilters()
        );



        $this->assertEquals(
            [
                $regularExpressionValidator
            ],
            $field->getValidators()
        );



//TODO



        $this->assertTrue(
            $field->isValid("this-is-valid")
        );

        $this->assertEquals(
            [],
            $field->getMessages()
        );



        $this->assertFalse(
            $field->isValid("This is not valid.")
        );

        $this->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages()
        );



        $this->assertFalse(
            $field->isValid("")
        );

        $this->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages()
        );
    }

    public function testValidator()
    {
        $field = new \Sid\Forms\Field("thisIsTheName");



        $notEmptyValidator = new \Zend\Validator\NotEmpty();

        $field->addValidator($notEmptyValidator);



        $this->assertEquals(
            [
                $notEmptyValidator
            ],
            $field->getValidators()
        );



        $this->assertTrue(
            $field->isValid("This is not empty.")
        );

        $this->assertEquals(
            [],
            $field->getMessages()
        );



        $this->assertFalse(
            $field->isValid("")
        );

        $this->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $field->getMessages()
        );



        $this->assertTrue(
            $field->isValid("This is not empty.")
        );

        $this->assertEquals(
            [],
            $field->getMessages()
        );
    }
}
