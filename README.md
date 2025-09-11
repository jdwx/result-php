# jdwx/result

A microscopic PHP module for managing complex function call results.

## Installation

You can require it directly with Composer:

```bash
composer require jdwx/result
```

Or download the source from GitHub: https://github.com/jdwx/result-php.git

## Requirements

This module requires PHP 8.3 or later.

## Usage

This module provides a simple way to report the results of a function call, including success/failure state and a message. It is
**loosely** inspired by the `Result` type in Rust.

Here is a basic usage example:

```php
function ExampleFunction() : Result {
    return match( random_int( 0, 1 ) ) {
        0 => Result::err( 'This is an error message.' ),
        1 => Result::ok( 'This is an example message.', 42 ),
    };
}

$result = ExampleFunction();
if( $result->isOK() ) {
    echo "Success ({$result}) with value: ", $result->value(), "\n";
} else {
    echo "Error: {$result}\n";

    # This will throw an exception
    $result->value();
}
```

## Stability

This module is considered stable and is used in production code.

## History

This module was refactored out of a private repository in September 2025 when the same functionality was needed for an unrelated project. DRY!
