@php
use Carbon\Carbon;use Illuminate\Support\Str;

@endphp
<div class="col-xl-7 col-md-6 fix-details">
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title text-capitalize">
                Fixture Details
            </div>
        </div>
        <div class="card-body">
            <div class="card custom-card">
                {{-- <div class="card-header">--}}

                {{-- </div>--}}
                {{-- @if($show_fixture)--}}
                <div class="card-body">

                    <div class="list-unstyled mb-0 analytics-visitors-countries">

                        <li class="border-bottom p-2 pb-4 fixture active">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <span class="badge bg-info fontSize16">{{ Carbon::parse($fixture?->match_date . $fixture?->match_time)->format('j F Y g:i A') }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <span class="badge bg-primary fontSize16">{{ $fixture?->status?->trans() }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-center ">
                                <div class="me-1 lh-1">
                                    <span class="fontSize20">{{ $fixture?->homeClub?->name }}</span>
                                </div>
                                <div class="lh-1">
                                    <span class="avatar avatar-sm avatar-rounded text-default">
                                        <img src="{{ $fixture?->homeClub?->fileUrl }}" alt="">
                                    </span>
                                </div>

                                <div class="mx-2 fontSize20 d-flex justify-content-center justify-content-between">
                                    <div class="">
                                        <input type="number" wire:model="home_club_result" class="form-control w-50 text-center ms-auto" />
                                    </div>
                                    <div class="mx-2">-</div>
                                    <div class="">
                                        <input type="number" wire:model="away_club_result" class="form-control w-50 text-center  me-auto" />
                                    </div>
                                    {{ $fixture?->home_club_result ?? null }}
                                    - {{ $fixture?->away_club_result ?? null }}
                                </div>

                                <div class="lh-1">
                                    <span class="avatar avatar-sm avatar-rounded text-default">
                                        <img src="{{ $fixture?->awayClub?->fileUrl }}" alt="">
                                    </span>
                                </div>
                                <div class="ms-1  lh-1">
                                    <span class="fontSize20">{{ $fixture?->awayClub?->name }}</span>
                                </div>
                            </div>
                        </li>
                        <ul class="nav nav-tabs mb-3 nav-justified nav-style-1 d-sm-flex d-block" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#home1-justified" aria-selected="false">Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#fixture-events" aria-selected="false">
                                    Events
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" role="tab" href="#Lineup" aria-selected="false">Lineup</a>
                            </li>
                            {{-- <li class="nav-item active">--}}
                            {{-- <a class="nav-link active" data-bs-toggle="tab" role="tab"--}}
                            {{-- href="#service1-justified" aria-selected="true">Team</a>--}}
                            {{-- </li>--}}
                            {{-- <li class="nav-item">--}}
                            {{-- <a class="nav-link" data-bs-toggle="tab" role="tab" href="#license1-justified"--}}
                            {{-- aria-selected="false">License</a>--}}
                            {{-- </li>--}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane text-muted show active" id="home1-justified" role="tabpanel">
                                {{-- update statistics--}}
                                @foreach($fixture_statistics as $key => $st)
                                <div class="d-flex justify-content-between mb-4">
                                    <div class="">
                                        <input type="number" wire:model="fixture_statistics.{{$key}}.home_club" class="form-control w-75 text-center ms-auto" />
                                    </div>

                                    <div class="">
                                        {{ Str::replace('_',' ',$key) }}
                                    </div>
                                    <div class="">
                                        <input type="number" wire:model="fixture_statistics.{{$key}}.away_club" class="form-control text-center w-75 me-auto" />
                                    </div>

                                </div>
                                @endforeach
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" wire:click.prevent="save_statistics">Update Statistics
                                    </button>
                                </div>
                            </div>


                            <div class="tab-pane text-muted" id="fixture-events" role="tabpanel">
                                <livewire:admin.fixture.page.fixture-event :fixture="$fixture" />
                            </div>


                            <div class="tab-pane text-muted" id="Lineup" role="tabpanel">
                                <li class="border-bottom p-2 pb-4 fixture active p-5">
                                    @if($fixture?->status?->value == 'finished')
                                        <livewire:admin.fixture.page.all-played-players :fixture="$fixture" />
                                    @else
                                        <livewire:admin.fixture.page.fixtuer-line-up :fixture="$fixture" />
                                    @endif
                                </li>
                            </div>
                            {{-- <livewire:admin.fixtuerlineup.model.update/>
                            <livewire:admin.fixtuerlineup.model.create/> --}}


                            {{-- <div class="tab-pane show active text-muted" id="service1-justified"--}}
                            {{-- role="tabpanel">--}}
                            {{-- There are many variations of passages of <b>Lorem Ipsum available</b>, but the--}}
                            {{-- majority have suffered alteration in some form, by injected humour, or--}}
                            {{-- randomised words which don't look even slightly believable. If you are going to--}}
                            {{-- use a passage of Lorem Ipsum, you need to be sure there isn't anything.--}}
                            {{-- </div>--}}
                            {{-- <div class="tab-pane text-muted" id="license1-justified" role="tabpanel">--}}
                            {{-- It is a long established fact that a reader will be distracted by the--}}
                            {{-- <b><i>Readable content</i></b> of a page when looking at its layout. The point--}}
                            {{-- of using Lorem Ipsum is that it has a more-or-less normal distribution of--}}
                            {{-- letters, as opposed to using 'Content here, content here', making it look like--}}
                            {{-- readable English.--}}
                            {{-- </div>--}}
                        </div>
                    </div>

                </div>
                {{-- @endif--}}
            </div>
        </div>

    </div>
</div>

@push('css')
<style>
    .fix-details .avatar.avatar-sm {
        width: 4rem;
        height: 4rem;
    }

    .fix-details .fontSize20 {
        font-size: 18px;
        font-weight: 700;
    }

    .fix-details .fontSize16 {
        font-size: 13px;
    }

</style>
@endpush
