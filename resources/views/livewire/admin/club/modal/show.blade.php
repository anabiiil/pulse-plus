<div>
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Profile</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xxl-12 col-xl-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <div class="d-sm-flex align-items-top p-4 border-bottom border-block-end-dashed main-profile-cover">
                        <div>
                            <span class="avatar avatar-xxl avatar-rounded online me-3">
                                <img src="{{ $club->fileUrl }}" alt="">
                            </span>
                        </div>
                        <div class="flex-fill main-profile-info">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fw-semibold mb-1 text-fixed-white">{{ $club->name }}</h6>
                                <button class="btn btn-light btn-wave" wire:click="$dispatch('update_club',{ id: {{ $club->id }}})"><i class="ri-edit-box-fill me-1 align-middle d-inline-block"></i>Edit Club</button>
                            </div>
                            <p class="mb-1 text-muted text-fixed-white op-7">{{ $club->official_name }}</p>
                            <p class="fs-12 text-fixed-white mb-4 op-5">
                                <span class="me-3"><i class="ri-building-line me-1 align-middle"></i>{{ $club->country?->name }}</span>
                                <span><i class="ri-map-pin-line me-1 align-middle"></i>{{ $club->country?->region }} - {{ $club->country?->subregion }}</span>
                            </p>
                            <div class="d-flex mb-0">
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">{{ $club->players->count() }}</p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">Players</p>
                                </div>
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">{{ $club->homeFixtures->count()  + $club->awayFixtures->count()}}</p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">All Fixtures</p>
                                </div>
                                <div class="me-4">
                                    <p class="fw-bold fs-20 text-fixed-white text-shadow mb-0">
                                        {{ $club->favoritedByUsers->count() }}
                                    </p>
                                    <p class="mb-0 fs-11 op-5 text-fixed-white">Following</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-12 col-xl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body p-0">
                            <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                                <div>
                                    <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts-tab-pane" type="button" role="tab" aria-controls="posts-tab-pane" aria-selected="false"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Statistics</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="players-tab" data-bs-toggle="tab" data-bs-target="#players-tab-pane" type="button" role="tab" aria-controls="players-tab-pane" aria-selected="false"><i class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Players</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="matches-tab" data-bs-toggle="tab" data-bs-target="#matches-tab-pane" type="button" role="tab" aria-controls="matches-tab-pane" aria-selected="false"><i class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Matches</button>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="p-3">
                                <div class="tab-content" id="myTabContent">
                                    {{--
                                        <div class="tab-pane show active fade p-0 border-0" id="history-tab-pane" role="tabpanel" aria-labelledby="history-tab" tabindex="0">
                                            <livewire:admin.club.modal.history :club_id="$club_id" />
                                        </div>
                                    --}}
                                    <div class="tab-pane show active fade p-0 border-0" id="posts-tab-pane" role="tabpanel" aria-labelledby="posts-tab" tabindex="0">
                                        <livewire:admin.club.modal.statistics :club_id="$club_id" />
                                    </div>
                                    <div class="tab-pane fade p-0 border-0" id="players-tab-pane" role="tabpanel" aria-labelledby="players-tab" tabindex="0">
                                        <livewire:admin.club.table.club-players-all :club_id="$club_id" />
                                    </div>
                                    <div class="tab-pane fade p-0 border-0" id="matches-tab-pane" role="tabpanel" aria-labelledby="matches-tab" tabindex="0">
                                        <livewire:admin.club.modal.matches :club_id="$club_id" />
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
    <livewire:admin.club.modal.update />

</div>
