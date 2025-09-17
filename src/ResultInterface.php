<?php


declare( strict_types = 1 );


namespace JDWX\Result;


use Stringable;


interface ResultInterface extends Stringable {


    public function hasMessage() : bool;


    public function hasValue() : bool;


    public function isError() : bool;


    public function isOK() : bool;


    public function message() : ?string;


    public function messageEx() : string;


    public function unwrap() : mixed;


    public function unwrapEx() : mixed;


    public function unwrapOr( mixed $i_default ) : mixed;


    /** @deprecated */
    public function value() : mixed;


    /** @deprecated */
    public function valueEx() : mixed;


    public function withMessage( ?string $i_nstMessage ) : ResultInterface;


    public function withValue( mixed $i_xValue ) : ResultInterface;


}