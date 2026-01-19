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
use App\Http\Controllers\TestController;
use App\Jobs\RunBackupJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;



Route::group(
    [
        'middleware' => ['auth:admin']
    ],
    function () {

        Route::get('/', function () {

            return redirect()->to('dash');
        })->name('home');

    }


);
