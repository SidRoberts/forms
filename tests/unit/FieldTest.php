<?php

namespace Sid\Forms\Tests\Unit;

use Codeception\TestCase\Test;

use Sid\Forms\Field;

use Zend\Filter\Word\DashToCamelCase;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class FieldTest extends Test
{
    public function testGetters()
    {
        $field = new Field("thisIsTheName");

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
            $field->getMessages(
                []
            )
        );
    }

    public function testFilter()
    {
        $field = new Field("thisIsTheName");



        $dashToCamelCaseFilter = new DashToCamelCase();

        $field->addFilter($dashToCamelCaseFilter);




        $regularExpressionValidator = new Regex(
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
            $field->getMessages("this-is-valid")
        );



        $this->assertFalse(
            $field->isValid("This is not valid.")
        );

        $this->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages("This is not valid.")
        );



        $this->assertFalse(
            $field->isValid("")
        );

        $this->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages("")
        );
    }

    public function testValidator()
    {
        $field = new Field("thisIsTheName");



        $notEmptyValidator = new NotEmpty();

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
            $field->getMessages("This is not empty.")
        );



        $this->assertFalse(
            $field->isValid("")
        );

        $this->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $field->getMessages("")
        );



        $this->assertTrue(
            $field->isValid("This is not empty.")
        );

        $this->assertEquals(
            [],
            $field->getMessages("This is not empty.")
        );
    }
}
