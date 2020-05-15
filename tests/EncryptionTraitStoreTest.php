<?php

namespace HiHaHo\EncryptableTrait\Tests;

use HiHaHo\EncryptableTrait\Tests\Fixtures\Payment;
use HiHaHo\EncryptableTrait\Tests\Fixtures\Phone;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;

class EncryptionTraitStoreTest extends TestCase
{
    private $testCreditCardNumber = '4242 4242 4242 4242';

    public function testCreatePayment()
    {
        $payment = new Payment();
        $payment->creditcard = $this->testCreditCardNumber;
        $payment->amount = 15;
        $payment->save();

        $this->assertEquals(15, $payment->amount);
        $this->assertEquals($this->testCreditCardNumber, $payment->creditcard);
    }

    public function testDatabaseData()
    {
        $payment = new Payment();
        $payment->creditcard = $this->testCreditCardNumber;
        $payment->amount = 15;
        $payment->save();

        $dbPayment = DB::table('payments')->where('id', $payment->id)->first();
        $this->assertEquals($this->testCreditCardNumber, decrypt($dbPayment->creditcard));
    }

    public function testThrowException()
    {
        $this->expectException(DecryptException::class);
        $id = DB::table('payments')->insertGetId(
            ['creditcard' => 'this does not work', 'amount' => 15]
        );

        $payment = Payment::find($id);
        $payment->creditcard;
    }

    public function testDontThrowException()
    {
        $id = DB::table('phones')->insertGetId(
            ['brand' => 'HTC', 'imei' => '351451-20-840121-6']
        );

        $phone = Phone::find($id);
        $this->assertNull($phone->imei);
        $this->assertEquals('HTC', $phone->brand);
    }
}
