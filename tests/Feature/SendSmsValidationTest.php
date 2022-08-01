<?php

namespace Tests\Feature;

use App\Models\Sms;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SendSmsValidationTest extends TestCase
{
    use WithFaker;

    public User $user;

    /** @test */
    public function it_needs_some_attributes(): void
    {
        $attributes = [
            'text' => Sms::factory()->raw()['text'],
        ];

        $response = $this->post(route('user.send-sms.store', $this->user->id), $attributes);

        $response->assertSuccessful();
    }

    /** @test */
    public function it_gave_you_error_with_empty_text(): void
    {
        $attributes = [
            'text' => '',
        ];

        $response = $this->post(route('user.send-sms.store', $this->user->id), $attributes);

        $response->assertInvalid('text');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_gave_you_error_with_no_text(): void
    {
        $attributes = [];

        $response = $this->post(route('user.send-sms.store', $this->user->id), $attributes);

        $response->assertInvalid('text');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }
}
