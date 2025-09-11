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


    public function testValueExForErrorNoValue() : void {
        $res = Result::err( 'Something went wrong.' );
        $this->expectException( \RuntimeException::class );
        $res->valueEx();
    }


    public function testValueExForErrorValue() : void {
        $res = Result::err( 'Something went wrong.', 42 );
        $this->expectException( \RuntimeException::class );
        $res->valueEx();
    }


    public function testValueExForSuccessNoValue() : void {
        $res = Result::ok();
        $this->expectException( \RuntimeException::class );
        $res->valueEx();
    }


    public function testValueExForSuccessValue() : void {
        $res = Result::ok( 'All good.', 42 );
        self::assertSame( 42, $res->valueEx() );
    }


}
