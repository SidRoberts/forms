<?php

namespace Tests;

use Sid\Forms\Field;
use Zend\Filter\Word\DashToCamelCase;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;

class FieldCest
{
    public function getters(UnitTester $I)
    {
        $field = new Field("thisIsTheName");

        $I->assertEquals(
            "thisIsTheName",
            $field->getName()
        );

        $I->assertEquals(
            [],
            $field->getFilters()
        );

        $I->assertEquals(
            [],
            $field->getValidators()
        );

        $I->assertEquals(
            [],
            $field->getMessages(
                []
            )
        );
    }

    public function testFilter(UnitTester $I)
    {
        $field = new Field("thisIsTheName");



        $dashToCamelCaseFilter = new DashToCamelCase();

        $field->addFilter($dashToCamelCaseFilter);




        $regularExpressionValidator = new Regex(
            "/^[A-Za-z]+$/"
        );

        $field->addValidator($regularExpressionValidator);



        $I->assertEquals(
            [
                $dashToCamelCaseFilter
            ],
            $field->getFilters()
        );



        $I->assertEquals(
            [
                $regularExpressionValidator
            ],
            $field->getValidators()
        );



        $I->assertTrue(
            $field->isValid("this-is-valid")
        );

        $I->assertEquals(
            [],
            $field->getMessages("this-is-valid")
        );



        $I->assertFalse(
            $field->isValid("This is not valid.")
        );

        $I->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages("This is not valid.")
        );



        $I->assertFalse(
            $field->isValid("")
        );

        $I->assertEquals(
            [
                "regexNotMatch" => "The input does not match against pattern '/^[A-Za-z]+$/'"
            ],
            $field->getMessages("")
        );
    }

    public function testValidator(UnitTester $I)
    {
        $field = new Field("thisIsTheName");



        $notEmptyValidator = new NotEmpty();

        $field->addValidator($notEmptyValidator);



        $I->assertEquals(
            [
                $notEmptyValidator
            ],
            $field->getValidators()
        );



        $I->assertTrue(
            $field->isValid("This is not empty.")
        );

        $I->assertEquals(
            [],
            $field->getMessages("This is not empty.")
        );



        $I->assertFalse(
            $field->isValid("")
        );

        $I->assertEquals(
            [
                "isEmpty" => "Value is required and can't be empty"
            ],
            $field->getMessages("")
        );



        $I->assertTrue(
            $field->isValid("This is not empty.")
        );

        $I->assertEquals(
            [],
            $field->getMessages("This is not empty.")
        );
    }
}
