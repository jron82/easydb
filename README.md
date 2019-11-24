# EasyDB

This is the PHP client to connect with easydb.io databases.


# Installation

**Requires PHP 7.1**

At present you just have to do a git clone of this repo and update your autoloader like so:

`
"autoload": {
        "psr-4": {
            "YourProject\\":"./src",
            "EasyDB\\": "./path-to-easydb-directory"
        }
    },
`

But as soon as it's on packagist you can just do a composer install.

# Usage

## Instantiation

`use EasyDB\EasyDB;`

`$config = require __DIR__ . '/config/databases.php';`

`$db = new EasyDB('db1', $config); `

This assumes your environment variables are already loaded and you are using this not as a part of a framework.
 
For example, if you are using  Laravel, you could just do this:

`use EasyDB\EasyDB;`

`$db = new EasyDB('db1', config('easydb.db1')); `

The config file has the ability to use multiple databases, and this instance I used the first one in the config file.

## List

`$db->list()` 

Returns all values stored.

## Put

`$db->put('test', 'hello world')`

This operation will store scalar values as well as arrays. However **please note** that this operation already uses json_encode.

If you'd like to add your own custom options for the encoding use `$db->put_raw(json(encode($key, WHATEVER_JSON_OPTION)))` instead. 

## Get

`$db->get($key)` 

Returns the value associated with the key. **Please note** this returns the raw json, so if you want an array you will have to call json_encode
for yourself if you need to. For scalars you won't need to to this but if you stored an array and want to work on it server side, you will.

## Delete

`$db->delete($key)`

Deletes the value associated with the key add returns and empty string. 

# Testing

If you want to run the tests, make sure you copy the .env.example to .env and fill it enter the credentials, or as mentioned above,
inject the config variables in some other way.