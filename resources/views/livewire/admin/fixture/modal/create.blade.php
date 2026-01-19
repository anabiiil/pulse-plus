<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body add-products p-0">
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="p-4">

                        <div class="row gx-5">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="competition_id" class="form-label">Competition</label>
                                                <select wire:model.live="competition_id" class="form-control"
                                                        id="competition_id" wire:change="filterCompetitionWeeks()">>
                                                    <option value="">select competition</option>
                                                    @foreach ($competitions as $competition)
                                                        <option value="{{ $competition->id }}">{{ $competition->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('competition_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">

                                                <label for="week_id" class="form-label">competition week</label>
                                                <select wire:model.live="week_id" class="form-control"
                                                        id="week_id">
                                                    <option value="">select competition week</option>
                                                    @foreach ($competition_weeks as $competition_week)
                                                        <option value="{{ $competition_week->id }}">
                                                            {{ $competition_week->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('start_week_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">

                                                <label for="season_id" class="form-label">Season</label>
                                                <select wire:model.live="season_id" class="form-control"
                                                        id="season_id">
                                                    <option value="">select season</option>
                                                    @foreach ($seasons as $season)
                                                        <option value="{{ $season->id }}">
                                                            {{ $season->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('season_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">

                                                <label for="home_club_id" class="form-label">Home Club</label>
                                                <select wire:model.live="home_club_id" class="form-control"
                                                        id="home_club_id">
                                                    <option value="">select home club</option>
                                                    @foreach ($clubs as $club)
                                                        <option value="{{ $club->id }}">
                                                            {{ $club->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('home_club_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">

                                                <label for="away_club_id" class="form-label">Away Club</label>
                                                <select wire:model.live="away_club_id" class="form-control"
                                                        id="away_club_id">
                                                    <option value="">select away club</option>
                                                    @foreach ($clubs as $club)
                                                        <option value="{{ $club->id }}">
                                                            {{ $club->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('away_club_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="match_date" class="form-label">Match Date</label>
                                                <input wire:model.live="match_date" type="date" class="form-control"
                                                       id="match_date" placeholder="Enter Match Date">
                                                @error('match_date')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="match_time" class="form-label">Match Time</label>
                                                <input wire:model.live="match_time" type="time" class="form-control"
                                                       id="match_time" placeholder="Enter Match Time">
                                                @error('match_time')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="match_period" class="form-label">Match Period</label>
                                                <input wire:model.live="match_period" min="0" type="number"
                                                       class="form-control" id="match_period"
                                                       placeholder="Enter Match Period">
                                                @error('match_period')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div> --}}

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="match_stadium" class="form-label">Match Stadium</label>
                                                <input wire:model.live="match_stadium" min="0" type="text"
                                                       class="form-control" id="match_stadium"
                                                       placeholder="Enter Match Stadium">
                                                @error('match_stadium')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="px-4 py-3  border-block-start-dashed d-sm-flex justify-content-end">


                        <button type="submit" class="btn btn-primary-light m-1">
                            <span class="indicator-label" wire:loading.class="d-none">
                                Save <i class="bi bi-plus-lg ms-2"></i>
                            </span>
                            <span class="d-none" wire:loading.class.remove="d-none">
                                Wait <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->
