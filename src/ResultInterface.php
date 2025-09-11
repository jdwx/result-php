<?php


declare( strict_types = 1 );


namespace JDWX\Result;


use Stringable;


interface ResultInterface extends Stringable {


    public function hasMessage() : bool;


    public function hasValue() : bool;


    public function isError() : bool;


    public function isOK() : bool;


    public function value() : mixed;


}