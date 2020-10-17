<h1 align="center">Laravel Translations</h1>

<p align="center">
    <strong>Supercharged instant translations for any Laravel project.</strong>
</p>

<p align="center">
    <a href="https://github.com/ramsey/composer-install"><img src="http://img.shields.io/badge/source-ramsey/composer--install-blue.svg?style=flat-square" alt="Source Code"></a>
    <a href="https://github.com/ramsey/composer-install/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-MIT-darkcyan.svg?style=flat-square" alt="Read License"></a>
    <a href="https://github.com/ramsey/composer-install/actions?query=workflow%3ACI"><img src="https://img.shields.io/github/workflow/status/ramsey/composer-install/CI?logo=github&style=flat-square" alt="Build Status"></a>
    <a href="https://codecov.io/gh/ramsey/composer-install"><img src="https://img.shields.io/codecov/c/gh/ramsey/composer-install?label=codecov&logo=codecov&style=flat-square" alt="Codecov Code Coverage"></a>
    <a href="https://phpc.chat/channel/ramsey"><img src="https://img.shields.io/badge/phpc.chat-%23ramsey-darkslateblue?style=flat-square" alt="Chat with the maintainers"></a>
</p>

## Contents

* [About the Project](#about)
* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Configuration](#configuration)
* [Extending](#extending)
* [Contributing](#contributing)
* [Copyright and Licence](#copyright-and-licence)
* [Contact](#contact)

## About

Laravel Translate provides instant free translations using Google, AWS, Bing or any other translation service. It also allows translations to be set in language files and the database to provide a truly flexible translation tool.

- Translate any text instantly using a multitude of translation services, without tying yourself to a specific service.
- Commit specific translations to version control.
- Use the frontend to specify translation overrides.
- Easily extensible.
- Fully tested.

## Installation

All you need to do to use this project is pull it into an existing Laravel app using composer.

```shell script
composer require twigger/laravel-translate
```

You can publish the configuration file by running 
```shell script
php artisan vendor:publish --provider=\Twigger\Translate\TranslationServiceProvider
```

## Basic Usage

Laravel Translate can be used with no configuration. To ensure this package can be used for any project, we provide multiple entry points including a Facade and an API. 

### Using the Facade

The easiest way to translate any text is to use the ```Translate``` facade. The following line will translate 'A string to translate' from English to French.

```php
$frenchString = \Twigger\Translate\Translate::translate('A string to translate', 'fr', 'en');
```

The translate function takes the string to translate as the first argument, the language to translate to (the target language) as the second argument and the source language as the third.

There is an alternative function called ```translateMany```, which takes an array of strings rather than a single string. This is useful for efficiently translating multiple strings at the same time.

```php
$frenchStrings = \Twigger\Translate\Translate::translateMany(['A string to translate', 'A second string to translate'], 'fr', 'en');
```

#### Target Language

The target language will depend on your end user. They may have the language set in their browser, your app may give them language options, or you may wish to use the default Laravel locale.

To simplify the detection of this language, the Laravel Translate package provides a detection facade.

```php
$targetLocale = \Twigger\Translate\Detect::lang();
```

The strategies used to detect the requested locale can be modified, which is described further in the [configuration](#configuration) section.

#### Source Language

The source language is required, as many websites may have content written in multiple languages. If this is not the case, we recommend passing in the Laravel locale as a sensible default.

```php
\Twigger\Translate\Translate::translate('A string to translate', 'fr', \Illuminate\Support\Facades\App::getLocale());
```

You may then edit the ```locale``` key in your ```config/app.php``` file to define the default locale.

### Using the API

The Laravel Translate package provides an API for translating any text. The endpoint is defined in the configuration file, but defaults to ```_translate```. The source and target language are automatically detected as described above.

#### Translating single lines

##### Request

```http request
POST /_translate HTTP/1.1
Accept: application/json
Content-Type: application/json
{
    "line": "A line to translate"
}
```

##### Response

```http request
HTTP/1.1 200 OK
Content-Type: application/json
{
   "translation": "The translated line in the detected language"
}
```

#### Translating multiple lines

##### Request

```http request
POST /_translate HTTP/1.1
Accept: application/json
Content-Type: application/json
{
    "lines": [
        "A line to translate",
        "Another line to translate",
    ]
}
```

##### Response

```http request
HTTP/1.1 200 OK
Content-Type: application/json
{
   "translations": [
        "The translated line in the detected language",
        "The second translated line in the detected language",
    ]
}
```

#### Overriding the source and target language

This will translate the line from english to french. Although ```target_lang``` and ```source_lang``` are not required, either or both may be given to override the default behaviour of the API.
##### Request

```http request
POST /_translate HTTP/1.1
Accept: application/json
Content-Type: application/json
{
    "line": "A line to translate",
    "target_lang": "fr",
    "source_lang": "en"
}
```

##### Response

```http request
HTTP/1.1 200 OK
Content-Type: application/json
{
   "translation": "The translated line in the detected language"
}
```

TODO Document more

### Using the js translator

TODO JS translator with debouncing

### Using Blade

TODO Blade directive

### Using the helper function

TODO Helper function

### Overriding translations

TODO Using the DB to override translations

## Configuration

- Setting up the package (service provider)
- Config options. Also defining more config directly

## Extending

- Writing a handler
- Writing an interceptor
- What's the difference? THe buck stops with the handler - should be able to translate anything.

## Contributing

Contributions are welcome! Before contributing to this project, familiarize
yourself with [CONTRIBUTING.md](CONTRIBUTING.md).

## Copyright and Licence

This package is copyright © [Toby Twigger](https://github.com/tobytwigger)
and licensed for use under the terms of the MIT License (MIT). Please see
[LICENCE.md](LICENCE.md) for more information.

## Contact
