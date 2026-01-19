<div>
    <div class="col-xxl-12 col-xl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body p-0">
                <div class="d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed main-profile-cover">
                    <div>
                        <span class="avatar avatar-xxl avatar-rounded online me-3">
                            <img src="{{ $user->fileUrl }}" alt="">
                        </span>
                    </div>
                    <div class="flex-fill main-profile-info">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="fw-semibold mb-1 text-fixed-white">{{ $user->first_name }} {{ $user->last_name }}</h6>
                            {{-- <button class="btn btn-light btn-wave waves-effect waves-light"><i class="ri-add-line me-1 align-middle d-inline-block"></i>Follow</button> --}}
                        </div>
                        <div class="d-flex mb-0">
                            <div class="me-4">
                                <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">113</p>
                                <p class="mb-0 fs-11 op-5 text-fixed-white">Points</p>
                            </div>
                            <div class="me-4">
                                <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">12.2k</p>
                                <p class="mb-0 fs-11 op-5 text-fixed-white">Followers</p>
                            </div>
                            <div class="me-4">
                                <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">128</p>
                                <p class="mb-0 fs-11 op-5 text-fixed-white">Following</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-4 border-bottom border-block-end-dashed">
                    <p class="fs-15 mb-2 me-4 fw-semibold">Contact Information :</p>
                    <div class="text-muted">
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-mail-line align-middle fs-14"></i>
                            </span>
                            {{ $user->email }}
                        </p>
                        <p class="mb-2">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-phone-line align-middle fs-14"></i>
                            </span>
                            {{ $user->dial_code }} {{ $user->phone }}
                        </p>
                        <p class="mb-0">
                            <span class="avatar avatar-sm avatar-rounded me-2 bg-light text-muted">
                                <i class="ri-map-pin-line align-middle fs-14"></i>
                            </span>
                            {{ $user->country?->name }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body p-0">
                                <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                                    <div>
                                        <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="team-tab" data-bs-toggle="tab" data-bs-target="#team-tab-pane" type="button" role="tab" aria-controls="team-tab-pane" aria-selected="true"><i class="fa fa-users me-1 align-middle d-inline-block"></i>Team</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @if($team)
                                <div class="p-3">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane show active fade p-0 border-0" id="team-tab-pane" role="tabpanel" aria-labelledby="team-tab" tabindex="0">
                                            <div class="col-lg-12">
                                                    @foreach($weeks as $week)
                                                        <button type="button"
                                                                class="btn {{ $week->id == $week_id ? 'btn-primary' : 'btn-outline-primary' }}"
                                                                wire:click="getWeekData('{{$week->id}}')">
                                                             {{ $week->name }}</button>
                                                    @endforeach
                                            </div>
                                            <div class="row justify-content-center border  p-2">

                                                <div class="col-lg-4">
                                                    <div class="table-responsive">
                                                        @if($team_players->count() > 0)
                                                        <table class="table text-nowrap table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-center bg-primary text-light" colspan="3">{{ $team->name }}</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center" scope="col">#</th>
                                                                    <th class="text-center" scope="col">player</th>
                                                                    <th class="text-center" scope="col">postion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center bg-primary text-light" colspan="3">Main</th>
                                                                </tr>
                                                                @foreach($team_players as $player)
                                                                    @if($loop->iteration <= 11)
                                                                        <tr>
                                                                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                                                            <td class="text-start">{{ $player->player?->name }} @if($player->is_captain) <i class="fa fa-star text-warning"></i> @endif  </td>
                                                                            <td class="text-center">
                                                                                <span class="badge {{ $player->player->positionColor($player->player->position->value) }}">{{ $player->player->position }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    @else
                                                                        @if($loop->iteration == 12)
                                                                            <tr>
                                                                                <th class="text-center bg-primary text-light" colspan="3">Substitutes</th>
                                                                            </tr>
                                                                        @endif
                                                                        <tr>
                                                                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                                                            <td class="text-start text-muted">{{ $player->player?->name }}</td>
                                                                            <td class="text-center text-muted">
                                                                                <span class="badge {{ $player->player?->positionColor($player->player?->position->value) }}">{{ $player->player?->position?->value }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @else
                                                            <div class="alert alert-danger" role="alert">
                                                                No data found for this week
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="p-2">

                                    <div class="alert alert-danger" role="alert">
                                        this user has no team
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
