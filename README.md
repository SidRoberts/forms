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
$emailField = new \Sid\Forms\Field("email");

$passwordField = new \Sid\Forms\Field("password");
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
$loginForm = new \Sid\Forms\Form();



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
