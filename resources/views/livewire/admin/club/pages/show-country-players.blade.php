<div>
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed main-profile-cover">

                        <div class="flex-fill main-profile-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fw-semibold mb-1 text-fixed-white">{{ $country->name }}</h6>
                            </div>
                            <p class="fs-12 text-fixed-white mb-4 op-5">
                                <span class="me-3"><i class="ri-building-line me-1 align-middle"></i> {{ $country->region }}</span>
                                <span><i class="ri-map-pin-line me-1 align-middle"></i> {{ $country->subregion }}</span>
                            </p>
                            <div class="d-flex mb-0">
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0"> {{ $players->count() }}</p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">Players</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 ">
            <div class="card">

                <div class="table-responsive">
                    <table class="table text-nowrap table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Avatar</th>
                                <th scope="col">Player Name</th>
                                <th scope="col">Club</th>
                                <th scope="col">Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $player)
                            <tr>
                                <td>
                                    <div class="avatar avatar-sm me-2 avatar-rounded">
                                        <img src="{{ $player->fileUrl }}" alt="img">
                                    </div>
                                </td>
                                <th scope="row">{{ $player->name }}</th>
                                <td>{{ $player->current_club->name }}</td>
                                <td>{{ $player->totalPoints }} P</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
