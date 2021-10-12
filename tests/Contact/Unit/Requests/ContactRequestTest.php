<?php

namespace Tests\Contact\Unit\Requests;

use App\Modules\Contact\Requests\ContactRequest;
use PHPUnit\Framework\TestCase;

class ContactRequestTest extends TestCase
{
    /** @var ContactRequest */
    private $tester;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tester = new ContactRequest();
    }

    public function testRules()
    {
        $this->assertEquals(
            [
                'fullname' => 'required|between:3,64|regex:/^[0-9a-zA-z ]+$/',
                'company'  => 'nullable|max:64|regex:/^[0-9a-zA-z ]+$/',
                'email'    => 'required|email|max:254',
                'reason'   => 'required|max:254|regex:/^[0-9a-zA-z,. ]+$/',
                'message'  => 'required|between:10,2048|regex:/^[0-9a-zA-z?,.\r\n ]+$/',
            ],
            $this->tester->rules()
        );
    }
}
