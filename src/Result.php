<?php


declare( strict_types = 1 );


namespace JDWX\Result;


readonly class Result implements ResultInterface {


    public function __construct( public bool $bOK = true, public ?string $nstMessage = null, public mixed $xValue = null ) {}


    public static function err( ?string $i_stMessage = null, mixed $i_xValue = null ) : self {
        return new self( false, $i_stMessage, $i_xValue );
    }


    public static function ok( ?string $i_stMessage = null, mixed $i_xValue = null ) : self {
        return new self( true, $i_stMessage, $i_xValue );
    }


    public function __toString() : string {
        return $this->nstMessage ?? '(no message)';
    }


    public function hasMessage() : bool {
        return ! empty( $this->nstMessage );
    }


    public function hasValue() : bool {
        return ! is_null( $this->xValue );
    }


    public function isError() : bool {
        return ! $this->bOK;
    }


    public function isOK() : bool {
        return $this->bOK;
    }


    /**
     * @return mixed The value associated with this result.
     * @throws \RuntimeException if this result is an error.
     *
     * This is the safe way to get the value, as it will throw an exception if the result is an error.
     * If you want to get the value without checking, you can access the xValue property directly.
     */
    public function value() : mixed {
        if ( ! $this->bOK ) {
            throw new \RuntimeException( "Cannot get value from error result: {$this}" );
        }
        return $this->xValue;
    }


}
