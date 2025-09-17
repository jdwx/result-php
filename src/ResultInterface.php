<?php


declare( strict_types = 1 );


namespace JDWX\Result;


use Stringable;


interface ResultInterface extends Stringable {


    public function hasMessage() : bool;


    public function hasValue() : bool;


    public function isError() : bool;


    public function isOK() : bool;


    public function unwrap() : mixed;


    public function unwrapEx() : mixed;


    public function unwrapOr( mixed $i_default ) : mixed;


    /** @deprecated */
    public function value() : mixed;


    /** @deprecated */
    public function valueEx() : mixed;


}