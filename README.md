# Forms

Quickly validate an array of data using Zend Filter and Zend Validator. This library does not concern itself with HTML rendering - only validation.

[![Build Status](https://travis-ci.org/SidRoberts/forms.svg?branch=master)](https://travis-ci.org/SidRoberts/forms)
[![GitHub tag](https://img.shields.io/github/tag/sidroberts/forms.svg?maxAge=2592000)]()



## Installation

```bash
composer require sidroberts/forms
```



## Example

Let's create a login form with a email and a password field. First, we need to
create these fields:

```php
use Sid\Forms\Field;

$emailField = new Field("email");

$passwordField = new Field("password");
```

Now we need to add some filters and validators to these fields. Obviously,
neither of these fields should be empty and the email field should contain a
valid email address:

```php
$trimFilter = new \Zend\Filter\StringTrim();

$notEmptyValidator = new \Zend\Validator\NotEmpty();

$emailValidator = new \Zend\Validator\EmailAddress();



$emailField->addFilter($trimFilter);

$emailField->addValidator($notEmptyValidator);
$emailField->addValidator($emailValidator);



$passwordField->addValidator($notEmptyValidator);
```

Filters are applied before validating the data.

Now we need to encapsulate them into a Form:

```php
use Sid\Forms\Form;

$loginForm = new Form();



$loginForm->add($emailField);

$loginForm->add($passwordField);
```

Validating data against these filters and validators is as easy as:

```php
$success = $loginForm->isValid($_POST);
```

If the data isn't valid, you can find out why:

```php
$errorMessages = $loginForm->getMessages($_POST);
```

To reuse the same form in multiple places, you can extend the Form class and
define the Fields in the constructor:

```php
<?php

use Sid\Forms\Field;
use Sid\Forms\Form;

use Zend\Filter\StringTrim;
use Zend\Validator\NotEmpty;

class LoginForm extends Form
{
    public function __construct()
    {
        $this->add(
            $this->createUsernameField()
        );

        $this->add(
            $this->createPasswordField()
        );
    }



    protected function createUsernameField() : Field
    {
        $usernameField = new Field("username");

        $usernameField->addFilter(
            new StringTrim()
        );

        $usernameField->addValidator(
            new NotEmpty()
        );

        return $usernameField;
    }

    protected function createPasswordField() : Field
    {
        $passwordField = new Field("password");

        $passwordField->addValidator(
            new NotEmpty()
        );

        return $passwordField;
    }
}
```

I personally like to create methods using the `create...Field` naming scheme
instead of defining everything in the constructor.
