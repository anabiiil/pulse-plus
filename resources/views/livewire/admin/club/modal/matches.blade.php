<div>
    <div class="card-header">
        <div class="card-title text-capitalize">
            <h3>Club Matches</h3>
        </div>
    </div>

    <div class="d-flex my-2 mx-2">
        @foreach(seasons() as $season)
        <button type="button" class="btn mx-1 {{ $season->id == $season_id ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="getSeasonData({{$season->id}},{{$season->id}})"> Season {{ $season->name }}</button>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-2">

            <div class="table-responsive">
                <table class="table text-nowrap table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Week</th>
                            <th class="text-center" scope="col">Date</th>
                            <th class="text-center" scope="col">Home</th>
                            <th class="text-center" scope="col">Result</th>
                            <th class="text-center" scope="col">Away</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($weeks->count() > 0)
                        @foreach ($weeks as $week)
                        @if($club->allClubFixtuerBySeasonWeek($season_id , $week->id)->count() > 0)

                        @foreach ($club->allClubFixtuerBySeasonWeek($season_id , $week->id) as $fixture )
                        <tr>
                            <th class="text-center" rowspan="{{ $club->allClubFixtuerBySeasonWeek($season_id , $week->id)->count() }}">
                                {{ $week->name }}
                            </th>
                            <td class="text-center"><span class="badge bg-dark">{{ $fixture->match_date }}</span></td>
                            <th class="text-center" scope="row">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class=" col-lg-6 avatar avatar-xs me-2  avatar-rounded">
                                        <img src="{{ $fixture?->homeClub?->fileUrl }}" alt="">
                                    </span>
                                    <span class=" col-lg-6 text-start ">
                                        {{ $fixture?->homeClub?->name }}
                                    </span>
                                </div>
                            </th>
                            <td class="text-center"> {{ $fixture?->home_club_result ?? null }} - {{ $fixture?->away_club_result ?? null }}</td>
                            <th class="text-center" scope="row">
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="col-lg-6 avatar avatar-xs me-2  avatar-rounded">
                                        <img src="{{ $fixture?->awayClub?->fileUrl }}" alt="">
                                    </span>
                                    <span class=" col-lg-6 text-start ">
                                        {{ $fixture?->awayClub?->name }}
                                    </span>
                                </div>
                            </th>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" rowspan="2" class="text-center bg-danger text-light">No Data for this season</td>
                        </tr>
                        @php
                        break;
                        @endphp
                        @endif
                        @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">No Data for this season</td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>
