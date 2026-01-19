<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CalculatePointController;
use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\CompetitionWeekController;
use App\Http\Controllers\Admin\CountryController;

use App\Http\Controllers\Admin\ClubController;
use App\Http\Controllers\Admin\CompetitionController;
use App\Http\Controllers\Admin\FixtureController;
use App\Http\Controllers\Admin\IconCategoryController;
use App\Http\Controllers\Admin\IconController;
use App\Http\Controllers\Admin\InstructionController;
use App\Http\Controllers\Admin\InstructionPointController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\NationalityController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StadiumController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::group(['middleware' => ['guest:admin']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
});


Route::group(
    [
        'middleware' => ['auth:admin']
    ],
    function () {

        Route::get('/', function () {

            return view('pages.admin.home');
        })->name('home');

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // -------- Players ---------

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::get('/country', [CountryController::class, 'index'])->name('country');
        Route::get('/country/export', [CountryController::class, 'export'])->name('country.export');

        // -------- Players ---------

        Route::get('/nationality', [NationalityController::class, 'index'])->name('nationality');
        // -------- Players ---------
        Route::resource('/player', PlayerController::class);
        Route::get('/export-players', [PlayerController::class, 'export'])->name('players.export');
        // -------- Players ---------

        // -------- Clubs ---------
        Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
        Route::get('/clubs/nations', [ClubController::class, 'nations'])->name('clubs.index.nations');
        Route::get('/clubs/{club_id}', [ClubController::class, 'show'])->name('clubs.show');
        Route::get('/clubs/nations/{country_id}', [ClubController::class, 'show_country_players'])->name('clubs.nations.show');
        Route::get('/export-clubs', [ClubController::class, 'export'])->name('clubs.export');
        // -------- Clubs ---------

        // -------- Seasons ---------
        Route::get('/seasons', [SeasonController::class, 'index'])->name('seasons.index');
        Route::get('/export-seasons', [SeasonController::class, 'export'])->name('seasons.export');
        // -------- Seasons ---------


        Route::resource('leagues', LeagueController::class);
        Route::get('/export-leagues', [LeagueController::class, 'export'])->name('leagues.export');

        // -------- Competitions ---------
        Route::get('/competitions', [CompetitionController::class, 'index'])->name('competitions.index');
        Route::get('/competitions/{competition}', [CompetitionController::class, 'show'])->name('competitions.show');
        Route::get('/export-competitions', [CompetitionController::class, 'export'])->name('competitions.export');
        // -------- Competitions ---------

        // -------- Competition Weeks ---------
        Route::get('/competition-weeks', [CompetitionWeekController::class, 'index'])->name('competition_weeks.index');
        Route::get('/export-competition-weeks', [CompetitionWeekController::class, 'export'])->name('competition_weeks.export');

        // -------- Competition Weeks ---------

        // -------- Instructions ---------
        Route::get('/instructions', [InstructionController::class, 'index'])->name('instructions.index');
        Route::get('/export-instructions', [InstructionController::class, 'export'])->name('instructions.export');
        // -------- Instructions ---------

        // -------- Instruction Points ---------
        Route::get('/instruction_points/{instruction}', [InstructionPointController::class, 'index'])->name('instruction_points.index');
        // -------- Instruction Points ---------

        // -------- Fixtures ---------
        Route::resource('fixtures', FixtureController::class);
        Route::get('/export-fixtures', [FixtureController::class, 'export'])->name('fixtures.export');

        // -------- Fixtures ---------

        // -------- stadiums ---------
        Route::get('/stadiums', [StadiumController::class, 'index'])->name('stadiums.index');
        Route::get('/export-stadiums', [StadiumController::class, 'export'])->name('stadiums.export');
        // -------- stadiums ---------

        // -------- icon-categories ---------
        Route::get('/icon-categories', [IconCategoryController::class, 'index'])->name('icon_categories.index');
        // -------- icon-categories ---------

        // -------- icons ---------
        Route::get('/icons', [IconController::class, 'index'])->name('icons.index');
        // -------- icons ---------

        // -------- admins ---------
        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        // -------- admins ---------


        // -------- users ---------
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');
        // -------- users ---------


        // -------- static pages ---------
        Route::get('/static-pages', [StaticPageController::class, 'index'])->name('static_pages.index');
        // -------- static pages ---------

        // -------- sliders ---------
        Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
        // -------- sliders ---------


        // -------- onboarding ---------
        Route::get('/on-boardings', [SliderController::class, 'on_boarding'])->name('on_boarding.index');
        // -------- onboarding ---------


        // -------- CalculatePoints ---------
        Route::get('/calculate-points', [CalculatePointController::class, 'index'])->name('calculate-point.index');
        // -------- CalculatePoint ---------

        Route::get('/coaches', [CoachController::class, 'index'])->name('coaches');


        Route::get('/backups', function () {
            // Get the disk where backups are stored
            $disk = config('backup.backup.destination.disks')[0]; // The default disk is 'local'

            // Get the folder where backups are stored
            $backupFolder = 'laravel-backup'; // Modify this if your backup folder is different

            // Get a list of backup files
            $files = Storage::disk($disk)->files($backupFolder);

            // Sort the files by last modified time in descending order (latest first)
            $backups = collect($files)->map(function ($file) use ($disk) {
                return [
                    'filename' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk($disk)->size($file),
                    'lastModified' => Storage::disk($disk)->lastModified($file),
                ];
            })->sortByDesc('lastModified')->toArray();

            return view('pages.admin.backups.index', compact('backups'));
        });


        Route::get('/backups/delete/{filename}', function ($filename) {
            $disk = config('backup.backup.destination.disks')[0];
            $backupFolder = config('app.name');
            $filePath = $backupFolder . '/' . $filename;

            if (Storage::disk($disk)->exists($filePath)) {
                Storage::disk($disk)->delete($filePath);
                return redirect()->back()->with('success', 'Backup deleted successfully.');
            }

            return redirect()->back()->with('error', 'Backup file not found.');
        })->name('backups.delete');




        Route::get('/backups/download/{filename}', function ($filename) {
            // Get the disk where backups are stored
            $disk = config('backup.backup.destination.disks')[0];

            // Get the folder where backups are stored
            $backupFolder = config('app.name');

            // Create the full path to the backup file
            $filePath = $backupFolder . '/' . $filename;

            // Check if the file exists
            if (!Storage::disk($disk)->exists($filePath)) {
                return redirect()->back()->with('error', 'Backup file not found.');
            }

            // Download the backup file
            return Storage::disk($disk)->download($filePath);
        })->name('backups.download');

        //        Route::get('/create-backup', function () {
//            RunBackupJob::dispatch();
//            return redirect()->back();
//        });

    }


);
