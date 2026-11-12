<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Personnel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransferSafeguardingExpiryTest extends TestCase
{
    use RefreshDatabase;

    private function person(string $role, array $extra = []): Personnel
    {
        $club = Club::factory()->create();
        $id = DB::table('personnels')->insertGetId(array_merge([
            'club_id' => $club->id, 'role' => $role, 'name' => 'A B',
            'safeguarding_completion' => '2025-01-01', 'safeguarding_expiry' => '2028-01-01',
            'created_at' => now(), 'updated_at' => now(),
        ], $extra));

        return Personnel::find($id);
    }

    public function test_dates_go_to_the_level_for_the_role_and_existing_levels_are_kept(): void
    {
        $head = $this->person('Head Coach');
        $children = $this->person('Childrens Officer');
        $designated = $this->person('Designated Person');
        $kept = $this->person('Secretary', ['safeguarding_l1_expiry' => '2027-05-05']);

        $this->artisan('app:transfer-safeguarding-expiry')->assertSuccessful();

        $this->assertSame('2028-01-01', $head->fresh()->getRawOriginal('safeguarding_l1_expiry'));
        $this->assertNull($head->fresh()->safeguarding_l2_expiry);
        $this->assertSame('2028-01-01', $children->fresh()->getRawOriginal('safeguarding_l2_expiry'));
        $this->assertSame('2028-01-01', $designated->fresh()->getRawOriginal('safeguarding_l3_expiry'));
        $this->assertSame('2027-05-05', $kept->fresh()->getRawOriginal('safeguarding_l1_expiry'));
    }

    public function test_dry_run_writes_nothing(): void
    {
        $head = $this->person('Head Coach');

        $this->artisan('app:transfer-safeguarding-expiry', ['--dry-run' => true])->assertSuccessful();

        $this->assertNull($head->fresh()->safeguarding_l1_expiry);
    }
}
