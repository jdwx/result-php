<?php


declare( strict_types = 1 );


use JDWX\Result\Result;


require_once __DIR__ . '/../vendor/autoload.php';


/** @return Result<int> */
function ExampleFunction() : Result {
    return match ( random_int( 0, 1 ) ) {
        0 => Result::err( 'This is an error message.' ),
        1 => Result::ok( 'This is an example message.', 42 ),
    };
}


( static function () : void {

    $result = ExampleFunction();
    if ( $result->isOK() ) {
        echo "Success ({$result}) with value: ", $result->value(), "\n";
    } else {
        echo "Error: {$result}\n";

        # This will throw an exception
        $result->value();
    }

} )();
