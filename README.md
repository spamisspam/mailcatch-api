# SpamIsSpam Mail Catch Support Library

[![Author](https://img.shields.io/badge/author-btafoya@briantafoya.com-blue.svg?style=flat-square)](https://www.briantafoya.com)
[![GitHub Tag](https://img.shields.io/github/tag/spamisspam/mailcatch-api.svg?style=flat-square)](https://github.com/spamisspam/mailcatch-api)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Packagist](https://img.shields.io/packagist/dt/spamisspam/mailcatch-api.svg?maxAge=86400&style=flat-square)](https://packagist.org/packages/spamisspam/mailcatch-api)
[![Build Status](https://travis-ci.org/spamisspam/mailcatch-api.svg?branch=master)](https://travis-ci.org/spamisspam/mailcatch-api)

### This is a support library for the Spam Is Spam Mail Catch platform.

It allows you to perform unit testing of smtp delivery and valid receipt.

Visit [Spam Is Spam Mail Catch](http://mailcatch.spamisspam.com) for more information.

Class documentation can be found in the generated [phpDoc](https://spamisspam.github.io/mailcatch-api/index.html).

### Requirements

    "require": {
        "php": ">=5.6.0",
        "ext-openssl": "*",
        "ext-curl": "*",
        "guzzlehttp/guzzle": "~6.0",
        "phpmailer/phpmailer": "^5.2",
        "squeaky-minds/squeaky-minds-php-helper": "^1.2.0"
    }

### Installation by Composer

    "require": {
        "spamisspam/mailcatch-api": "~1.0"
    }

Or

	$ composer require spamisspam/mailcatch-api
