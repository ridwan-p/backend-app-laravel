<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\AnnualLeave;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnualLeaveRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_can_list_annual_leaves()
    {
        $response = $this->actingAs($this->user, 'sanctum')
                         ->getJson('/annual-leaves');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => []
        ]);
    }

    /** @test */
    public function it_fails_to_store_annual_leave_due_to_invalid_dates()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/annual-leaves', [
            'start_date' => '2024-10-10',
            'end_date' => '2024-10-09', // invalid
            'description' => 'Test Description',
            'status' => 'pending'
            ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['end_date']);
    }

    /** @test */
    public function it_can_store_annual_leave_when_data_is_valid()
    {
        $leaveData = [
            'start_date' => '2024-10-10',
            'end_date' => '2024-10-20',
            'description' => 'Vacation',
            'status' => 'pending',
        ];

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/annual-leaves', $leaveData);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'start_date' => '2024-10-10',
                'end_date' => '2024-10-20',
                'description' => 'Vacation',
                'status' => 'pending',
            ]
        ]);
    }

    /** @test */
    public function it_can_show_an_annual_leave()
    {
        $leave = AnnualLeave::factory()->create(
            ['user_id' => $this->user->id]
        );

        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson("/annual-leaves/{$leave->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $leave->id,
                'start_date' => $leave->start_date,
                'end_date' => $leave->end_date,
                'description' => $leave->description,
                'status' => $leave->status,
            ]
        ]);
    }

    /** @test */
    public function it_returns_404_if_annual_leave_is_not_found()
    {
        $response = $this->actingAs($this->user, 'sanctum')
            ->getJson('/annual-leaves/9999');

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'fail',
            'message' => 'Annual leave is not found'
        ]);
    }
}
