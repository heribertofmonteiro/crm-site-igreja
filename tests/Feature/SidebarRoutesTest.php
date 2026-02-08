<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class SidebarRoutesTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    public function test_all_sidebar_routes_load_successfully()
    {
        $user = User::find(1);

        $routes = [
            'pastoral.councils.index',
            'pastoral.notes.index',
            'pastoral.doctrines.index',
            'dashboard',
            'admin.members.index',
            'admin.events.index',
            'admin.administration.documents.index',
            'admin.administration.departments.index',
            'admin.administration.announcements.index',
            'admin.administration.meeting-minutes.index',
            'admin.users.index',
            'admin.volunteer_roles.index',
            'admin.volunteer_schedules.index',
            'admin.worship.songs.index',
            'admin.worship.setlists.index',
            'admin.worship.teams.index',
            'admin.worship.rehearsals.index',
            'education.classes.index',
            'education.materials.index',
            'education.students.index',
            'admin.finance.accounts.index',
            'admin.finance.transactions.index',
            'admin.finance.transaction_categories.index',
            'admin.finance.budgets.index',
            'admin.donations.index',
            'financial-audits.index',
            'fiscal-council-meetings.index',
            'missions.missionaries.index',
            'missions.projects.index',
            'missions.supports.index',
            'patrimony.assets.index',
            'patrimony.maintenance_orders.index',
            'patrimony.space_bookings.index',
            'admin.media.index',
            'admin.media.categories.index',
            'admin.media.playlists.index',
            'admin.media.livestreams.index',
            'social.projects.index',
            'social.volunteers.index',
            'social.assistance.index',
            'admin.legal.legal_documents.index',
            'admin.legal.lgpd_consents.index',
            'admin.legal.compliance_obligations.index',
            'it.infrastructure.index',
            'it.security.index',
            'logs.audits',
            'logs.incidents',
            'qualidade.scan',
            'expansion.plans.index',
            'profile.edit',
        ];

        foreach ($routes as $routeName) {
            if (!Route::has($routeName)) {
                $this->fail("Route not found: {$routeName}");
                continue;
            }

            try {
                $response = $this->actingAs($user)->get(route($routeName));

                if ($response->status() !== 200) {
                     echo "\nFailed Route: " . $routeName . " | Status: " . $response->status() . "\n";
                     // Optional: print validation errors or exception message if available
                     if ($response->status() == 500) {
                         // Currently can't easily get the exception message in this concise block without more verbosity
                         // But we can check logs or just fail.
                     }
                }
                
                // Assert 200 OK
                $this->assertEquals(200, $response->status(), "Route {$routeName} failed with status " . $response->status());

            } catch (\Exception $e) {
                $this->fail("Route {$routeName} threw exception: " . $e->getMessage());
            }
        }
    }
}
