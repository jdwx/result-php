<?php


declare( strict_types = 1 );


namespace JDWX\Result\Tests;


use JDWX\Result\Result;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass( Result::class )]
final class ResultTest extends TestCase {


    public function testHasMessage() : void {
        $res = Result::ok();
        self::assertFalse( $res->hasMessage() );

        $res = Result::ok( 'All good.' );
        self::assertTrue( $res->hasMessage() );

        $res = Result::ok( 'All good.', 42 );
        self::assertTrue( $res->hasMessage() );

        $res = Result::err();
        self::assertFalse( $res->hasMessage() );

        $res = Result::err( 'Something went wrong.' );
        self::assertTrue( $res->hasMessage() );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertTrue( $res->hasMessage() );
    }


    public function testHasValue() : void {
        $res = Result::ok();
        self::assertFalse( $res->hasValue() );

        $res = Result::ok( 'All good.' );
        self::assertFalse( $res->hasValue() );

        $res = Result::ok( 'All good.', 42 );
        self::assertTrue( $res->hasValue() );

        $res = Result::err();
        self::assertFalse( $res->hasValue() );

        $res = Result::err( 'Something went wrong.' );
        self::assertFalse( $res->hasValue() );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertTrue( $res->hasValue() );
    }


    public function testIsError() : void {
        $res = Result::ok();
        self::assertFalse( $res->isError() );

        $res = Result::ok( 'All good.' );
        self::assertFalse( $res->isError() );

        $res = Result::ok( 'All good.', 42 );
        self::assertFalse( $res->isError() );

        $res = Result::err();
        self::assertTrue( $res->isError() );

        $res = Result::err( 'Something went wrong.' );
        self::assertTrue( $res->isError() );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertTrue( $res->isError() );
    }


    public function testIsOK() : void {
        $res = Result::ok();
        self::assertTrue( $res->isOK() );

        $res = Result::ok( 'All good.' );
        self::assertTrue( $res->isOK() );

        $res = Result::ok( 'All good.', 42 );
        self::assertTrue( $res->isOK() );

        $res = Result::err();
        self::assertFalse( $res->isOK() );

        $res = Result::err( 'Something went wrong.' );
        self::assertFalse( $res->isOK() );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertFalse( $res->isOK() );

    }


    public function testMessage() : void {
        $res = Result::ok();
        self::assertNull( $res->message() );

        $res = Result::ok( 'All good.' );
        self::assertSame( 'All good.', $res->message() );

        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 'All good.', $res->message() );

        $res = Result::err();
        self::assertNull( $res->message() );

        $res = Result::err( 'Something went wrong.' );
        self::assertSame( 'Something went wrong.', $res->message() );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertSame( 'Something went wrong.', $res->message() );
    }


    public function testMessageExForMessage() : void {
        $res = Result::ok( 'All good.' );
        self::assertSame( 'All good.', $res->messageEx() );
    }


    public function testMessageExForNoMessage() : void {
        $res = Result::ok();
        $this->expectException( \RuntimeException::class );
        $res->messageEx();
    }


    public function testToString() : void {
        $res = Result::ok();
        self::assertSame( '(no message)', strval( $res ) );

        $res = Result::ok( 'All good.' );
        self::assertSame( 'All good.', strval( $res ) );

        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 'All good.', strval( $res ) );

        $res = Result::err();
        self::assertSame( '(no message)', strval( $res ) );

        $res = Result::err( 'Something went wrong.' );
        self::assertSame( 'Something went wrong.', strval( $res ) );

        $res = Result::err( 'Something went wrong.', 42 );
        self::assertSame( 'Something went wrong.', strval( $res ) );
    }


    public function testUnwrap() : void {
        $res = Result::ok();
        self::assertNull( $res->unwrap() );

        $res = Result::ok( 'All good.' );
        self::assertNull( $res->unwrap() );

        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 42, $res->unwrap() );

        $res = Result::err();
        $this->expectException( \RuntimeException::class );
        $res->unwrap();
    }


    public function testUnwrapExForErrorNoValue() : void {
        $res = Result::err( 'Something went wrong.' );
        $this->expectException( \RuntimeException::class );
        $res->unwrapEx();
    }


    public function testUnwrapExForErrorValue() : void {
        $res = Result::err( 'Something went wrong.', 42 );
        $this->expectException( \RuntimeException::class );
        $res->unwrapEx();
    }


    public function testUnwrapExForSuccessNoValue() : void {
        $res = Result::ok();
        $this->expectException( \RuntimeException::class );
        $res->unwrapEx();
    }


    public function testUnwrapExForSuccessValue() : void {
        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 42, $res->unwrapEx() );
    }


    public function testUnwrapOr() : void {
        $res = Result::ok();
        self::assertSame( 99, $res->unwrapOr( 99 ) );

        $res = Result::ok( 'All good.' );
        self::assertSame( 99, $res->unwrapOr( 99 ) );

        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 42, $res->unwrapOr( 99 ) );
    }


    public function testUnwrapOrForError() : void {

        $res = Result::err();
        $this->expectException( \RuntimeException::class );
        $res->unwrapOr( 99 );

    }


    public function testUnwrapOrForErrorWithMessage() : void {

        $res = Result::err( 'Something went wrong.' );
        $this->expectException( \RuntimeException::class );
        $res->unwrapOr( 99 );

    }


    public function testUnwrapOrForErrorWithMessageAndValue() : void {
        $res = Result::err( 'Something went wrong.', 42 );
        $this->expectException( \RuntimeException::class );
        $res->unwrapOr( 99 );
    }


    /**
     * @noinspection PhpDeprecationInspection
     * @suppress PhanDeprecatedFunction
     */
    public function testValue() : void {
        $res = Result::ok();
        self::assertNull( $res->value() );

        $res = Result::ok( 'All good.' );
        self::assertNull( $res->value() );

        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 42, $res->value() );

        $res = Result::err();
        $this->expectException( \RuntimeException::class );
        $res->value();
    }


    /**
     * @noinspection PhpDeprecationInspection
     * @suppress PhanDeprecatedFunction
     */
    public function testValueEx() : void {
        $res = Result::err( 'Something went wrong.' );
        $this->expectException( \RuntimeException::class );
        $res->valueEx();
    }


    public function testWithMessage() : void {
        $res = Result::ok();
        self::assertFalse( $res->hasMessage() );
        self::assertNull( $res->message() );

        $res2 = $res->withMessage( 'All good.' );
        self::assertTrue( $res2->hasMessage() );
        self::assertSame( 'All good.', $res2->messageEx() );
        self::assertFalse( $res2->isError() );
        self::assertTrue( $res2->isOK() );
        self::assertFalse( $res2->hasValue() );
    }


    public function testWithValue() : void {
        $res = Result::ok();
        self::assertFalse( $res->hasValue() );
        self::assertNull( $res->unwrap() );
        self::assertSame( 99, $res->unwrapOr( 99 ) );

        $res2 = $res->withValue( 42 );
        self::assertTrue( $res2->hasValue() );
        self::assertSame( 42, $res2->unwrap() );
        self::assertSame( 42, $res2->unwrapOr( 99 ) );
    }


}
