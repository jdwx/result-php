<?php


declare( strict_types = 1 );


namespace JDWX\Result;


/**
 * @template T
 */
readonly class Result implements ResultInterface {


    /** @param T|null $xValue */
    public function __construct( public bool $bOK = true, public ?string $nstMessage = null, public mixed $xValue = null ) {}


    /**
     * @param string|null $i_stMessage The error message, if any.
     * @param mixed $i_xValue The value associated with this result, if any.
     * @return self An error result.
     *
     * Might be null!
     * @phpstan-ignore missingType.generics
     */
    public static function err( ?string $i_stMessage = null, mixed $i_xValue = null ) : self {
        return new self( false, $i_stMessage, $i_xValue );
    }


    /**
     * @param string|null $i_stMessage
     * @param mixed $i_xValue
     * @return self A successful result.
     *
     * Might be null!
     * @phpstan-ignore missingType.generics
     */
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


    public function message() : ?string {
        return $this->nstMessage;
    }


    public function messageEx() : string {
        return $this->message() ?? throw new \RuntimeException( "Result has no message: {$this}" );
    }


    /**
     * @return T|null The value associated with this result.
     * @throws \RuntimeException if this result is an error.
     *
     * This is the safe way to get the value, as it will throw an exception if the result is an error.
     * If you want to get the value without checking, you can access the xValue property directly.
     */
    public function unwrap() : mixed {
        if ( ! $this->bOK ) {
            throw new \RuntimeException( "Cannot get value from error result: {$this}" );
        }
        return $this->xValue;
    }


    /**
     * @return T The value associated with this result.
     * @throws \RuntimeException if this result has no value.
     *
     * This is the safe way to get the value, as it will throw an exception if the result has no value.
     * If you want to get the value without checking, you can access the xValue property directly.
     *
     * It would be great if PHP had official template support to resolve all these weird edge cases.
     * @noinspection PhpDocSignatureInspection
     */
    public function unwrapEx() : mixed {
        $x = $this->unwrap();
        if ( ! is_null( $x ) ) {
            return $x;
        }
        throw new \RuntimeException( "Result has no value: {$this}" );
    }


    public function unwrapOr( mixed $i_default ) : mixed {
        return $this->unwrap() ?? $i_default;
    }


    /**
     * @return T|null The value associated with this result.
     * @deprecated Use unwrap() instead.
     */
    public function value() : mixed {
        return $this->unwrap();
    }


    /**
     * @return T The value associated with this result.
     * @deprecated Use unwrapEx() instead.
     * @noinspection PhpDocSignatureInspection
     */
    public function valueEx() : mixed {
        return $this->unwrapEx();
    }


    /** @return self<T> */
    public function withMessage( ?string $i_nstMessage ) : self {
        return new self( $this->bOK, $i_nstMessage, $this->xValue );
    }


    /** @return self<T> */
    public function withValue( mixed $i_xValue ) : self {
        return new self( $this->bOK, $this->nstMessage, $i_xValue );
    }


}
