<div>
    <div class="col-xxl-12 col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title text-capitalize">
                    All Players Played in Match
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs tab-style-2 nav-justified mb-3 d-sm-flex d-block" id="myTab1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"><i class="ri-home-5-line me-1 align-middle"></i> {{ $fixture?->homeClub?->name }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirm-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false"><i class="ri-briefcase-line me-1 align-middle"></i>{{ $fixture?->awayClub?->name }}</button>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade text-muted" id="order-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Player</th>
                                        <th scope="col">Total Points</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fixtuer_lineups['home']['players'] as $player)
                                    <tr>
                                        <th scope="row">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td>{{ $player?->player?->name }}</td>
                                        <td>{{ $player?->player?->player_points()->where('fixture_id',$fixture->id)->sum('points') }}</td>
                                        <td>
                                            <button wire:click.prevent="$dispatch('add_bonus' , {player_id:{{ $player->player_id }} , fixture_id:{{ $fixture->id }}})" class="btn btn-sm btn-success btn-wave">
                                                <i class="ri-add-circle-fill"> </i>Add bonus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade show active text-muted" id="confirm-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Player</th>
                                        <th scope="col">Total Points</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fixtuer_lineups['away']['players'] as $player)
                                    <tr>
                                        <th scope="row">
                                            {{ $loop->iteration }}
                                        </th>
                                        <td>{{ $player?->player?->name }}</td>
                                        <td>{{ $player?->player?->player_points()->where('fixture_id',$fixture->id)->sum('points') }}</td>
                                        <td>
                                            <button wire:click.prevent="$dispatch('add_bonus' , {player_id:{{ $player->player_id }} , fixture_id:{{ $fixture->id }}})"  class="btn btn-sm btn-success btn-wave">
                                                <i class="ri-add-circle-fill"> </i> Add bonus
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <livewire:admin.fixture.modal.add-bonus />
</div>
