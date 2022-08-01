<?php

namespace Tests\Feature;

use App\Models\Sms;
use App\Models\User;
use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendSmsTest extends TestCase
{
    public User $user;
    public array $attributes;

    /** @test */
    public function it_can_be_call_by_anyone(): void
    {
        $response = $this->post(route('user.send-sms.store', $this->user->id), $this->attributes);

        $response->assertSuccessful();
    }

    /** @test */
    public function it_persist_data_in_sms_table(): void
    {
        $this->post(route('user.send-sms.store', $this->user->id), $this->attributes);

        $this->assertDatabaseCount((new Sms())->getTable(), 1);
    }

    /** @test */
    public function it_persist_exact_data_in_sms_table(): void
    {
        $this->post(route('user.send-sms.store', $this->user->id), $this->attributes);

        $this->assertDatabaseHas((new Sms())->getTable(), [
            'text' => $this->attributes['text'],
        ]);
    }

    /** @test */
    public function it_responses_json_include_sms_data(): void
    {
        $response = $this->post(route('user.send-sms.store', $this->user->id), $this->attributes);

        $this->assertDatabaseCount((new Sms())->getTable(), 1);

        $response->assertJson([
            'data' => [
                'text' => $this->attributes['text'],
            ],
        ]);
    }

    /** @test */
    public function it_makes_a_notification_send(): void
    {
        $this->post(route('user.send-sms.store', $this->user->id), $this->attributes);

        Notification::assertSentTo(
            [$this->user],
            SmsNotification::class
        );

        Notification::assertCount(1);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->attributes = [
            'text' => Sms::factory()->raw()['text'],
        ];

        $this->user = User::factory()->create();
    }
}
