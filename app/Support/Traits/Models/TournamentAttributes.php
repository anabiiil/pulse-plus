<?php
 namespace App\Support\Traits\Models;

 use App\Enums\Tournament\TournamentBadgeType;
 use Carbon\Carbon;
 use Illuminate\Database\Eloquent\Casts\Attribute;
 use Illuminate\Support\Str;

 trait TournamentAttributes
 {
     protected function tournamentTag(): Attribute
     {
         return Attribute::make(
             get: fn () => Str::random(7)
         );
     }
     protected function pickDate(): Attribute
     {
         return Attribute::make(
             get: fn () => Carbon::parse($this->start_date)->setTimezone('UTC')->format("Y-m-d H:i:s")
         );
     }
     protected function startDateFormat(): Attribute
     {
         return Attribute::make(
             get: fn () => Carbon::parse($this->start_date)->format('j F Y'),
         );
     }
     protected function endDateFormat(): Attribute
     {
         return Attribute::make(
             get: fn () => Carbon::parse($this->end_date)->format('j F Y'),
         );
     }
     protected function startChangesFormat(): Attribute
     {
         return Attribute::make(
             get: fn () => Carbon::parse($this->start_changes_at)->format('j F Y'),
         );
     }
     protected function endChangesFormat(): Attribute
     {
         return Attribute::make(
             get: fn () => Carbon::parse($this->end_changes_at)->format('j F Y'),
         );
     }
     protected function rank(): Attribute
     {
         return Attribute::make(
             get: fn () => (int)rand(1,10)
         );
     }
     protected function badgeType(): Attribute
     {
         $number = array_rand(TournamentBadgeType::values());
         return Attribute::make(
             get: fn () => TournamentBadgeType::values()[$number]
         );
     }
     protected function badgeName(): Attribute
     {
         $number = array_rand(TournamentBadgeType::names());
         $names = TournamentBadgeType::names();
         $name = $names[$number];
         return Attribute::make(
             get: fn () => TournamentBadgeType::getConstantByName($name)->trans()
         );
     }
 }
