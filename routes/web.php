<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\MediaCategoryController;
use App\Http\Controllers\MediaPlaylistController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\WorshipSongController;
use App\Http\Controllers\WorshipSetlistController;
use App\Http\Controllers\WorshipTeamController;
use App\Http\Controllers\WorshipRehearsalController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventVenueController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\EventResourceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\InstitutionalDocumentController;
use App\Http\Controllers\MeetingMinuteController;
use App\Http\Controllers\FinancialAccountController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\TransactionCategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SocialPostController;
use App\Http\Controllers\FinancialAuditController;
use App\Http\Controllers\FiscalCouncilMeetingController;
use App\Http\Controllers\EducationalMaterialController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DoctrineController;
use App\Http\Controllers\PastoralCouncilController;
use App\Http\Controllers\PastoralNoteController;
use App\Http\Controllers\MissionaryController;
use App\Http\Controllers\MissionProjectController;
use App\Http\Controllers\MissionSupportController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\MaintenanceOrderController;
use App\Http\Controllers\SpaceBookingController;
use App\Http\Controllers\InfrastructureAssetController;
use App\Http\Controllers\SecurityIncidentController;
use App\Http\Controllers\SocialProjectController;
use App\Http\Controllers\SocialVolunteerController;
use App\Http\Controllers\SocialAssistanceController;
use App\Http\Controllers\VolunteerRoleController;
use App\Http\Controllers\VolunteerScheduleController;
use App\Http\Controllers\CodeQualityController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\ChurchPlantingController;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\LgpdConsentController;
use App\Http\Controllers\ComplianceObligationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

// Public/Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // Breeze default dashboard (Redirect to main dashboard)
    Route::get('/dashboard', function () {
        return redirect()->route('dashboard');
    })->middleware(['verified']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Core Module
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('members', MemberController::class)->names('admin.members');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('donations', DonationController::class)->names('admin.donations');
    Route::resource('volunteer_roles', VolunteerRoleController::class)->names('admin.volunteer_roles');
    Route::resource('volunteer_schedules', VolunteerScheduleController::class)->names('admin.volunteer_schedules');
    
    // Media Module
    Route::resource('media', MediaController::class)->names('admin.media');
    Route::prefix('media')->group(function () {
        Route::resource('categories', MediaCategoryController::class)->names('admin.media.categories');
        Route::resource('playlists', MediaPlaylistController::class)->names('admin.media.playlists');
        Route::resource('livestreams', LiveStreamController::class)->names('admin.media.livestreams');
        
        Route::post('livestreams/{live_stream}/start', [LiveStreamController::class, 'startStream'])->name('admin.media.livestreams.start');
        Route::post('livestreams/{live_stream}/end', [LiveStreamController::class, 'endStream'])->name('admin.media.livestreams.end');
        Route::post('livestreams/{live_stream}/regenerate-key', [LiveStreamController::class, 'regenerateKey'])->name('admin.media.livestreams.regenerate-key');
        
        Route::post('playlists/{media_playlist}/add-media', [MediaPlaylistController::class, 'addMedia'])->name('admin.media.playlists.add-media');
        Route::delete('playlists/{media_playlist}/remove-media/{media}', [MediaPlaylistController::class, 'removeMedia'])->name('admin.media.playlists.remove-media');
        Route::put('playlists/{media_playlist}/reorder', [MediaPlaylistController::class, 'reorder'])->name('admin.media.playlists.reorder');
    });
    
    Route::prefix('legal')->group(function () {
        Route::resource('legal_documents', LegalDocumentController::class)->names('admin.legal.legal_documents');
        Route::resource('lgpd_consents', LgpdConsentController::class)->names('admin.legal.lgpd_consents');
        Route::resource('compliance_obligations', ComplianceObligationController::class)->names('admin.legal.compliance_obligations');
    });
});

// Events Module (V2)
Route::prefix('events')->middleware('auth')->group(function () {
    Route::resource('events', EventController::class)->names('admin.events');
    Route::resource('venues', EventVenueController::class)->names('admin.events.venues');
    Route::resource('registrations', EventRegistrationController::class)->names('admin.events.registrations');
    Route::resource('resources', EventResourceController::class)->names('admin.events.resources');
    
    Route::post('events/{event}/duplicate', [EventController::class, 'duplicate'])->name('admin.events.duplicate');
    Route::get('calendar', [EventController::class, 'calendar'])->name('admin.events.calendar');
    Route::put('events/{event}/status', [EventController::class, 'updateStatus'])->name('admin.events.update-status');
});

// Finance Module (V2)
Route::prefix('finance')->middleware('auth')->group(function () {
    Route::resource('financial_accounts', FinancialAccountController::class)->names('admin.finance.accounts');
    Route::resource('transactions', FinancialTransactionController::class)->names('admin.finance.transactions');
    Route::resource('transaction_categories', TransactionCategoryController::class)->names('admin.finance.transaction_categories');
    Route::resource('budgets', BudgetController::class)->names('admin.finance.budgets');
    Route::resource('financial_reports', FinancialReportController::class)->names('admin.finance.financial_reports');
    Route::resource('financial-audits', FinancialAuditController::class)->names('financial-audits');
    Route::resource('fiscal-council-meetings', FiscalCouncilMeetingController::class)->names('fiscal-council-meetings');
    
    // Financial Account Actions
    Route::post('financial_accounts/{financial_account}/update-balance', [FinancialAccountController::class, 'updateBalance'])->name('admin.finance.accounts.update-balance');
    Route::put('financial_accounts/{financial_account}/toggle-status', [FinancialAccountController::class, 'toggleStatus'])->name('admin.finance.accounts.toggle-status');
    
    // Transaction Actions
    Route::put('transactions/{financial_transaction}/reconcile', [FinancialTransactionController::class, 'reconcile'])->name('admin.finance.transactions.reconcile');
    Route::put('transactions/{financial_transaction}/unreconcile', [FinancialTransactionController::class, 'unreconcile'])->name('admin.finance.transactions.unreconcile');
    
    // Budget Actions
    Route::put('budgets/{budget}/update-actual', [BudgetController::class, 'updateActualAmount'])->name('admin.finance.budgets.update-actual');
});

// Pastoral Module
Route::prefix('pastoral')->middleware('auth')->group(function () {
    Route::resource('doctrines', DoctrineController::class)->names('pastoral.doctrines');
    Route::resource('councils', PastoralCouncilController::class)->names('pastoral.councils');
    Route::resource('notes', PastoralNoteController::class)->names('pastoral.notes');
});

// Worship Module
Route::prefix('worship')->middleware('auth')->group(function () {
    Route::resource('songs', WorshipSongController::class)->names('admin.worship.songs');
    Route::resource('setlists', WorshipSetlistController::class)->names('admin.worship.setlists');
    Route::resource('teams', WorshipTeamController::class)->names('admin.worship.teams');
    Route::resource('rehearsals', WorshipRehearsalController::class)->names('admin.worship.rehearsals');
    
    Route::get('songs/{worship_song}/chord-sheet', [WorshipSongController::class, 'chordSheet'])->name('admin.worship.songs.chord-sheet');
    Route::get('songs/{worship_song}/transpose', [WorshipSongController::class, 'transpose'])->name('admin.worship.songs.transpose');
    Route::get('setlists/{worship_setlist}/print', [WorshipSetlistController::class, 'print'])->name('admin.worship.setlists.print');
    Route::post('setlists/{worship_setlist}/duplicate', [WorshipSetlistController::class, 'duplicate'])->name('admin.worship.setlists.duplicate');
    Route::post('teams/{worship_team}/schedule-rehearsal', [WorshipTeamController::class, 'scheduleRehearsal'])->name('admin.worship.teams.schedule-rehearsal');
    Route::get('rehearsals/calendar', [WorshipRehearsalController::class, 'calendar'])->name('admin.worship.rehearsals.calendar');
});

// Missions & Projects
Route::prefix('missions')->middleware('auth')->group(function () {
    Route::resource('missionaries', MissionaryController::class)->names('missions.missionaries');
    Route::resource('projects', MissionProjectController::class)->names('missions.projects');
    Route::resource('supports', MissionSupportController::class)->names('missions.supports');
});

Route::prefix('patrimony')->middleware('auth')->group(function () {
    Route::resource('assets', AssetController::class)->names('patrimony.assets');
    Route::resource('maintenance_orders', MaintenanceOrderController::class)->names('patrimony.maintenance_orders');
    Route::resource('space_bookings', SpaceBookingController::class)->names('patrimony.space_bookings');
});

Route::prefix('it')->middleware('auth')->group(function () {
    Route::resource('infrastructure', InfrastructureAssetController::class)->names('it.infrastructure');
    Route::resource('security', SecurityIncidentController::class)->names('it.security');
});

// Administration & Documents
Route::prefix('administration')->middleware('auth')->group(function () {
    Route::resource('departments', DepartmentController::class)->names('admin.administration.departments');
    Route::resource('announcements', AnnouncementController::class)->names('admin.administration.announcements');
    Route::resource('documents', InstitutionalDocumentController::class)->names('admin.administration.documents');
    Route::resource('meeting-minutes', MeetingMinuteController::class)->names('admin.administration.meeting-minutes');
    
    Route::put('announcements/{announcement}/toggle-status', [AnnouncementController::class, 'toggleStatus'])->name('admin.administration.announcements.toggle-status');
});

// Education Module
Route::prefix('education')->middleware('auth')->group(function () {
    Route::resource('materials', EducationalMaterialController::class)->names('education.materials');
    Route::resource('classes', SchoolClassController::class)->names('education.classes');
    Route::resource('students', StudentController::class)->names('education.students');
});

Route::prefix('social')->middleware('auth')->group(function () {
    Route::resource('social_projects', SocialProjectController::class)->names('social.projects');
    Route::resource('social_volunteers', SocialVolunteerController::class)->names('social.volunteers');
    Route::resource('social_assistance', SocialAssistanceController::class)->names('social.assistance');
});

Route::prefix('qualidade')->middleware('auth')->group(function () {
    Route::get('scan', [CodeQualityController::class, 'scan'])->name('qualidade.scan');
    Route::get('critical', [CodeQualityController::class, 'critical'])->name('qualidade.critical');
    Route::get('queue', [CodeQualityController::class, 'queue'])->name('qualidade.queue');
});

Route::prefix('logs')->middleware('auth')->group(function () {
    Route::get('audits', [LogsController::class, 'audits'])->name('logs.audits');
    Route::get('incidents', [LogsController::class, 'incidents'])->name('logs.incidents');
    Route::get('export', [LogsController::class, 'export'])->name('logs.export');
    Route::get('cleanup', [LogsController::class, 'cleanup'])->name('logs.cleanup');
});

Route::prefix('expansion')->middleware('auth')->group(function () {
    Route::resource('church-planting-plans', ChurchPlantingController::class)->names('expansion.plans');
});

Route::middleware('web')->group(function () {
    Route::post('donation/store', [DonationController::class, 'store'])->name('donation.store');
    // Consolidate public registration if needed
});

require __DIR__.'/auth.php';

// Settings Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
    Route::post('settings/upload-logo', [SettingsController::class, 'uploadLogo'])->name('admin.settings.upload-logo');
    Route::delete('settings/delete-logo', [SettingsController::class, 'deleteLogo'])->name('admin.settings.delete-logo');
    Route::post('settings/reset', [SettingsController::class, 'resetToDefaults'])->name('admin.settings.reset');
});
