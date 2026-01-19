@php use Carbon\Carbon; @endphp
<div class="col-xl-5 col-md-6">
    <div class="card custom-card">
        <div class="card-header justify-content-between">
            <div class="card-title text-capitalize">
                Fixtures
            </div>
            <div class="prism-toggle">
                <a class="btn btn-primary-light m-1" href="{{route('admin.fixtures.create')}}">Add
                    New<i class="bi bi-plus-lg ms-2"></i></a>
                <button
                    class="btn btn-primary-light m-1"
                    data-bs-toggle="modal"
                    data-bs-target="#import_fixtures">Import
                </button>
                <a
                    class="btn btn-primary-light m-1"

                    href="{{ route('admin.fixtures.export') }}">Export</a>
            </div>
        </div>
        <div class="card-body">
            <div class="card custom-card">
                <div class="card-header container" >
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Select Season</label>
                            <select wire:model.live="season_id" class="form-select">
                                <option value="">Select Week</option>
                                @foreach ($seasons as $season)
                                    <option value="{{$season->id}}">{{$season->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label>Select Week</label>
                            <select wire:model.live="week_id" class="form-select">
                                <option value="">Select Week</option>
                                @foreach ($weeks as $week)
                                    <option value="{{$week->id}}">{{$week->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0 analytics-visitors-countries">
                        @foreach($fixtures as $fixture)
{{--                            {{ $fixture->id }}--}}
                            <li wire:click.prevent="$dispatch('show_fixture',{ id: {{ $fixture->id }}})"
                                class="border-bottom p-2 pb-4 fixture {{ $current_fixture_id == $fixture->id ? ' active' : '' }}"
                                >
                                <div class="d-flex align-items-center justify-content-center mb-3">
                            <span
                                class="badge bg-info ms-1">{{ Carbon::parse($fixture->match_date . $fixture->match_time)->format('j F Y g:i A') }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <span class="badge bg-primary">{{ $fixture->status?->trans() }}</span>
                                </div>

                                <div class="d-flex align-items-center justify-content-center ">
                                    <div class="me-1 lh-1">
                                        <span class="fs-12">{{ $fixture->homeClub?->name }}</span>
                                    </div>
                                    <div class="lh-1">QAJ
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <img src="{{ $fixture->homeClub?->fileUrl }}" alt="">
                            </span>
                                    </div>

                                    <div class="mx-2">
                                        {{ $fixture->home_club_result ?? null }}
                                        -{{ $fixture->away_club_result ?? null }}
                                    </div>

                                    <div class="lh-1">
                            <span class="avatar avatar-sm avatar-rounded text-default">
                                <img src="{{ $fixture->awayClub?->fileUrl }}" alt="">
                            </span>
                                    </div>
                                    <div class="ms-1  lh-1">
                                        <span class="fs-12">{{ $fixture->awayClub?->name }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>


@push('css')
    <style>
        .fixture.active {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }
    </style>
@endpush
