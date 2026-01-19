@php use App\Models\Competition; @endphp
<div class="match">
    <div class="match-header">
        <div class="badge {{ $fixture->status?->color() }}">{{ $fixture->status?->trans() }}</div>
        <div class="match-tournament"><img src="https://assets.codepen.io/285131/pl-logo.svg"/>
            {{ Competition::whereStatus(true)->first()?->name }}
        </div>
        <div class="match-actions">
            <button class="btn-icon"><i class="fa  fa-star"></i></button>
            <button class="btn-icon"><i class="fa fa-bell"></i></button>
        </div>
    </div>
    <div class="match-content">
        <div class="column">
            <div class="team team--home">
                <div class="team-logo">
                    <img src="https://assets.codepen.io/285131/whufc.svg"/>
                </div>
                <h2 class="team-name">{{$fixture->homeClub?->name}}</h2>
            </div>
        </div>
        <div class="column">
            <div class="match-details">
                <div class="match-date">
                    12 Aug at <strong>19:00</strong>
                </div>
                <div class="match-score ">
                    <input wire:model="home_club_result" class="form-control" type="number" value="0" step="1" min="0">

                    @error('home_club_result') <span class="text-danger">{{$message}}</span> @enderror
                    <span class="match-score-divider">:</span>

                    <input wire:model="away_club_result" class="form-control" type="number" value="0" step="1" min="0">
                    @error('home_club_result') <span class="text-danger">{{$message}}</span> @enderror
                </div>
                <div class="match-time-lapsed">
                    72'
                </div>
                <div class="match-referee">
                    Referee: <strong>Joseph Hicks</strong>
                </div>
                <div class="match-bet-options">
                    <button class="match-bet-option">1.48</button>
                    <button class="match-bet-option">4.98</button>
                    <button class="match-bet-option">8.24</button>
                </div>
                <button wire:click.prevent="store" class="match-bet-place">Place a bet</button>
            </div>
        </div>
        <div class="column">
            <div class="team team--away">
                <div class="team-logo">
                    <img src="https://assets.codepen.io/285131/chelsea.svg"/>
                </div>
                <h2 class="team-name">{{$fixture->awayClub?->name}}</h2>
            </div>
        </div>
    </div>
</div>
