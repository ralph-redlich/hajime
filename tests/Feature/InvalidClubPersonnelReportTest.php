<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Coach;
use App\Models\Personnel;
use App\Models\Volunteer;
use App\Support\InvalidClubPersonnel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvalidClubPersonnelReportTest extends TestCase
{
    use RefreshDatabase;

    private function club(string $name, string $status = 'Active'): Club
    {
        return Club::create([
            'name' => $name, 'status' => $status, 'city' => 'Dublin', 'county' => 'Dublin',
            'province' => 'Leinster', 'type' => 'Full', 'address1' => '1 Main St',
        ]);
    }

    private function personnel(Club $club, string $name, string $role, array $dates = []): Personnel
    {
        return Personnel::create(array_merge([
            'name' => $name, 'role' => $role, 'club_id' => $club->id,
            'vetting_expiry' => now()->addYear(), 'safeguarding_expiry' => now()->addYear(),
        ], $dates));
    }

    public function test_lists_each_invalid_person_once_with_slash_separated_reasons(): void
    {
        $club = $this->club('Alpha');
        $this->personnel($club, 'Ann', 'Secretary', [
            'vetting_expiry' => now()->subDay(), 'first_aid_expiry' => now()->subDay(),
        ]);
        $this->personnel($club, 'Valid', 'Head Coach');
        Coach::create(['name' => 'Cora', 'club_id' => $club->id, 'vetting_expiry' => now()->addYear(), 'safeguarding_expiry' => now()->subDay()]);
        Volunteer::create(['name' => 'Vic', 'club_id' => $club->id, 'vetting_expiry' => null, 'safeguarding_expiry' => now()->addYear()]);

        $rows = InvalidClubPersonnel::rows()->keyBy('name');

        $this->assertEqualsCanonicalizing(['Ann', 'Cora', 'Vic'], $rows->keys()->all());
        $this->assertSame('Vetting expired / First Aid expired', $rows['Ann']['reason']);
        $this->assertSame('Coach', $rows['Cora']['role']);
        $this->assertSame('Safeguarding expired', $rows['Cora']['reason']);
        $this->assertSame('Volunteer', $rows['Vic']['role']);
        $this->assertSame('Vetting not set', $rows['Vic']['reason']);
    }

    public function test_safeguarding_levels_get_their_own_reasons_and_blanks(): void
    {
        $club = $this->club('Levels');
        $this->personnel($club, 'Lee', 'Secretary', [
            'safeguarding_l1_expiry' => now()->addYear(),
            'safeguarding_l2_expiry' => now()->subDay(),
        ]);

        $row = InvalidClubPersonnel::rows()->first();

        $this->assertSame('Safeguarding L2 expired', $row['reason']);
        $this->assertNotNull($row['safeguarding_l1_expiry']);
        $this->assertNull($row['safeguarding_l3_expiry']);
    }

    public function test_designated_person_matches_compliance_report_for_every_club(): void
    {
        foreach (['A', 'B', 'C'] as $i => $name) {
            $club = $this->club($name);
            $this->personnel($club, "Old $name", 'Designated Person', ['vetting_expiry' => now()->subDay()]);
            if ($i > 0) {
                $this->personnel($club, "New $name", 'Designated Person', ['vetting_expiry' => now()->subDay()]);
            }
        }
        $this->club('NoDP');

        $report = InvalidClubPersonnel::rows()->where('role', 'Designated Person')->pluck('name', 'club');

        foreach (Club::all() as $club) {
            $expected = Personnel::designatedofficer()->where('club_id', $club->id)->first()?->name;
            $this->assertSame($expected, $report[$club->name] ?? null, $club->name);
        }
    }

    public function test_report_page_renders_and_export_downloads_as_xlsx(): void
    {
        $user = \App\Models\User::factory()->create();
        $user->assignRole(\Spatie\Permission\Models\Role::findOrCreate('admin'));
        $this->personnel($this->club('Alpha'), 'Ann', 'Secretary', ['vetting_expiry' => now()->subDay()]);

        $this->actingAs($user)->get(route('report.invalid.personnel'))
            ->assertOk()
            ->assertSee('Invalid Club Personnel')
            ->assertSee('Vetting expired')
            ->assertSee('Safeguarding L3');

        $response = $this->actingAs($user)->get(route('report.invalid.export'))->assertOk();
        $this->assertMatchesRegularExpression('/filename=.*invalid-club-personnel-\d{4}-\d{2}-\d{2}\.xlsx/', $response->headers->get('content-disposition'));
        $this->assertSame('PK', substr($response->baseResponse->getFile()->getContent(), 0, 2), 'xlsx is a zip file');
    }

    public function test_excludes_inactive_clubs(): void
    {
        $this->personnel($this->club('Closed', 'Inactive'), 'Gone', 'Secretary', ['vetting_expiry' => now()->subDay()]);

        $this->assertCount(0, InvalidClubPersonnel::rows());
    }

    public function test_stale_duplicate_designated_person_is_ignored(): void
    {
        $club = $this->club('Galway');
        $this->personnel($club, 'Ferdia', 'Designated Person', ['vetting_expiry' => now()->subDay()]);
        $this->personnel($club, 'Kevin', 'Designated Person', ['vetting_expiry' => now()->subDay()]);

        $rows = InvalidClubPersonnel::rows();

        $this->assertCount(1, $rows);
        $this->assertSame(
            Personnel::designatedofficer()->where('club_id', $club->id)->first()->name,
            $rows->first()['name']
        );
    }
}
