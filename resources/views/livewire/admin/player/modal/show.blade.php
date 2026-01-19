<div>
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed main-profile-cover">
                        <div class="m-2">
                            <img src="{{ $player->fileUrl }}" alt=""
                                 style="width: 131px;height: 131px;border-radius: 50%;">

                        </div>
                        <div class="flex-fill main-profile-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fw-semibold mb-1 text-fixed-white">{{ $player->name ?? '' }}</h6>
                                <a href="{{ url('admin/player/'.$player->id.'/edit') }}" class="btn  btn-success"><i
                                        class="ri-edit-box-fill me-1 align-middle d-inline-block"></i>Edit Player</a>
                            </div>
                            <p class="mb-1 text-muted text-fixed-white op-7">T-Shirt : {{ $player->t_shirt ?? '' }}</p>
                            <p class="fs-12 text-fixed-white mb-4 op-5">
                                <span class="me-3"> Position : <span
                                        class="badge text-white {{ $player?->position?->color()  ?? '' }}">{{ $player?->position?->value  ?? '' }}</span></span>
                                {{--                                <span><i class="ri-map-pin-line me-1 align-middle"></i>Washington D.C</span> --}}
                            </p>
                            <div class="d-flex mb-0">
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">{{ $player->price ?? 0 }}</p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">Price</p>
                                </div>
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">{{ $player?->current_club?->name ?? "" }}</p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">Current Club</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start:: row-11 -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-3" role="tablist">

                                        <li class="nav-item active">
                                            <a class="nav-link active" data-bs-toggle="tab" role="tab"
                                               href="#hometab-statistics" aria-selected="true">Statistics</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab"
                                               href="#hometab-dropdown" aria-selected="false">history</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" role="tab"
                                               href="#hometab-matches" aria-selected="false">Matches</a>
                                        </li>


                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane show active text-muted" id="hometab-statistics"
                                             role="tabpanel">
                                            <div class="card custom-card">
                                                <div class="card-header justify-content-between">
                                                    <div class="card-title text-capitalize">
                                                        Statistics
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <livewire:admin.player.tabs.statistics :player="$player"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane text-muted" id="hometab-dropdown"
                                             role="tabpanel">
                                            <div class="card custom-card">
                                                <div class="card-header justify-content-between">
                                                    <div class="card-title text-capitalize">
                                                        Club history
                                                    </div>
                                                    <div class="prism-toggle">
                                                        <button data-bs-toggle="modal"
                                                                data-bs-target="#create_club_season"
                                                                class="btn btn-light btn-wave"><i
                                                                class="ri-add-line me-1 align-middle d-inline-block"></i>ClubSeason
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <livewire:admin.player.tabs.club-season.table.all
                                                            player_id="{{ $player->id }}"/>
                                                    </div>
                                                    <livewire:admin.player.tabs.club-season.modal.create
                                                        player_id="{{ $player->id }}"/>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane text-muted" id="hometab-matches"
                                             role="tabpanel">
                                            <div class="card custom-card">
                                                <div class="card-header justify-content-between">
                                                    <div class="card-title text-capitalize">
                                                        Matches
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <livewire:admin.player.tabs.matches :club="$player?->current_club"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>

    </div>
    <!--End::row-1 -->
</div>
