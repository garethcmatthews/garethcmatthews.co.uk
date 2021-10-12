<?php

namespace Tests\Contact\Feature\Requests;

use Illuminate\Foundation\Testing\TestCase;
use Tests\CreateApplicationTrait;

use function rand;
use function str_repeat;
use function strlen;

class ContactRequestTest extends TestCase
{
    use CreateApplicationTrait;

    /** @var array */
    private $values = [
        'fullname' => 'Mr Testy McTestface',
        'company'  => 'The Company',
        'email'    => 'testy@test.com',
        'reason'   => 'I need a reason',
        'message'  => 'I also need a message',
    ];

    public function testAll(): void
    {
        $values = $this->values;

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    /**
     * Fullname
     *
     * Is Required
     * Must be between 3 and 64 characters
     * Must only contain 0-9 a-z A-Z and spaces
     *
     * @return void
     */
    public function testName(): void
    {
        $key          = 'fullname';
        $values       = $this->values;
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $values[$key] = $this->generateRandomString($characters, 64);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testName_IsRequired(): void
    {
        $key          = 'fullname';
        $expectError  = 'Please enter your fullname.';
        $values       = $this->values;
        $values[$key] = '';

        $response = $this->post('/contact', $values);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testName_Min(): void
    {
        $key          = 'fullname';
        $expectError  = 'The fullname must be between 3 and 64 characters.';
        $values       = $this->values;
        $values[$key] = str_repeat('A', 2);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testName_Max(): void
    {
        $key          = 'fullname';
        $expectError  = 'The fullname must be between 3 and 64 characters.';
        $values       = $this->values;
        $values[$key] = str_repeat('A', 65);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testName_DisallowedCharacters(): void
    {
        $key          = 'fullname';
        $characters   = '!"#$%&()*+,-';
        $expectError  = 'Invalid characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 64);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    /**
     * Company
     *
     * Is Not Required
     * Must be between 0 and 64 characters
     * Must only contain 0-9 a-z A-Z and spaces
     *
     * @return void
     */
    public function testCompany(): void
    {
        $key          = 'company';
        $values       = $this->values;
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $values[$key] = $this->generateRandomString($characters, 64);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testCompany_Min(): void
    {
        $key          = 'company';
        $values       = $this->values;
        $values[$key] = '';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testCompany_Max(): void
    {
        $key          = 'company';
        $expectError  = 'The company must not be greater than 64 characters.';
        $values       = $this->values;
        $values[$key] = str_repeat('A', 65);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testCompany_DisallowedCharacters(): void
    {
        $key          = 'company';
        $characters   = '!"#$%&()*+,-';
        $expectError  = 'Invalid characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 64);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    /**
     * Email
     *
     * Is Required
     * Must be a valid email
     * Must be a max length of 254
     *
     * @return void
     */
    public function testEmail(): void
    {
        $key          = 'email';
        $values       = $this->values;
        $values[$key] = 'test@validemail.com';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testEmail_Required(): void
    {
        $key          = 'email';
        $expectError  = 'Please enter your email address.';
        $values       = $this->values;
        $values[$key] = '';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testEmail_Invalid(): void
    {
        $key          = 'email';
        $expectError  = 'The email must be a valid email address.';
        $values       = $this->values;
        $values[$key] = 'testvalidemail.com';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testEmail_MaxLength(): void
    {
        $key          = 'email';
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $expectError  = 'The email must not be greater than 254 characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 126) . '@' . $this->generateRandomString($characters, 124) . '.com';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    /**
     * Reason
     *
     * Is Required
     * Must be max length of 254 characters
     * Must only contain 0-9 a-z A-Z,. spaces
     *
     * @return void
     */
    public function testReason(): void
    {
        $key          = 'reason';
        $values       = $this->values;
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $values[$key] = $this->generateRandomString($characters, 245);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testReason_Required(): void
    {
        $key          = 'reason';
        $values       = $this->values;
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $values[$key] = $this->generateRandomString($characters, 245);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testReason_MaxLength(): void
    {
        $key          = 'reason';
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $expectError  = 'The reason must not be greater than 254 characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 255);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testReason_DisallowedCharacters(): void
    {
        $key          = 'reason';
        $characters   = '!"#$%&()*+-';
        $expectError  = 'Invalid characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 254);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    /**
     * Message
     *
     * Is Required
     * Must be max length of 2048 characters
     * Must only contain 0-9 a-z A-Z,. spaces
     *
     * @return void
     */
    public function testMessage(): void
    {
        $key          = 'message';
        $values       = $this->values;
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $values[$key] = $this->generateRandomString($characters, 2048);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function testMessage_IsRequired(): void
    {
        $key          = 'message';
        $expectError  = 'Please enter your message.';
        $values       = $this->values;
        $values[$key] = '';

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testMessage_MinLength(): void
    {
        $key          = 'message';
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $expectError  = 'The message must be between 10 and 2048 characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 9);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testMessage_MaxLength(): void
    {
        $key          = 'message';
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ,. ';
        $expectError  = 'The message must be between 10 and 2048 characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 2049);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    public function testMessage_DisallowedCharacters(): void
    {
        $key          = 'message';
        $characters   = '!"#$%&()*+-';
        $expectError  = 'Invalid characters.';
        $values       = $this->values;
        $values[$key] = $this->generateRandomString($characters, 2048);

        $response = $this->post('/contact', $values);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([$key => $expectError]);
    }

    /**
     * Test Helpers
     */
    private function generateRandomString(string $characters, int $length = 10): string
    {
        $max    = strlen($characters);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, $max - 1)];
        }
        return $string;
    }
}
