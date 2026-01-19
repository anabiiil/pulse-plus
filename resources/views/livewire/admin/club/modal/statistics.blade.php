<div class="card">
    <div class="card-header">
        <div class="card-title text-capitalize">
            <h3>Club Statistics </h3>
        </div>
    </div>
    <div class="d-flex my-2 mx-2">

        <div class="d-flex my-2 mx-2">
            @foreach(seasons() as $season)
                <button type="button"
                        class="btn mx-1 {{ $season->id == $season_id ? 'btn-primary' : 'btn-outline-primary' }}"
                        wire:click="getSeasonData({{$season->id}},{{$season->id}})"> Season {{ $season->name }}</button>
            @endforeach
        </div>
    </div>
    @if($club_curent_season)

        <div class="table-responsive my-2">
            <table class="table text-nowrap table-bordered border-success">
                <thead>
                <tr>
                    <th class="bg-primary text-white text-center" colspan="{{ $club_season_statistcs->count() + 1 }}"
                        class="text-center">
                        <h4>  {{ $club_curent_season->season?->name }}</h4>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><span class="badge bg-light text-dark">possession</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">shoots</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">shoots on target</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">fouls</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">passes</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">corner kicks</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">saves</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">offside</span></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">
                        statistics
                    </th>

                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('possession' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('shoots' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('shoots_on_target' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('fouls' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('passes' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('corner_kicks' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('saves' , $season_id) }}</span>
                    </td>
                    <td>
                        <span
                            class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalBySeason('offside' , $season_id) }}</span>
                    </td>
                </tr>


                </tbody>
            </table>
        </div>
        <div class="table-responsive my-2">
            <table class="table text-nowrap table-bordered border-success">
                <thead>
                <tr>
                    <th class="bg-primary text-white text-center" colspan="{{ $club_season_statistcs->count() + 1 }}"
                        class="text-center">
                        <h4>  {{ $club_curent_season->season?->name }}</h4>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><span class="badge bg-light text-dark">possession</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">shoots</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">shoots on target</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">fouls</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">passes</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">corner kicks</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">saves</span></th>
                    <th scope="col"><span class="badge bg-light text-dark">offside</span></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($weeks as $week)
                    <tr>
                        <th scope="row">
                            {{ $week->name }}
                        </th>

                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('possession' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('shoots' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('shoots_on_target' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('fouls' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('passes' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('corner_kicks' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('saves' , $season_id , $week->id) }}</span>
                        </td>
                        <td>
                            <span
                                class="badge bg-light text-dark">{{ (int) $club_season_statistics->fixtureStatisticsTotalByWeek('offside' , $season_id , $week->id) }}</span>
                        </td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>
    @else

        <div class="card-body">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">No statistics found!</h4>
                <p>There are no statistics for the current season</p>
                <hr>
                <p class="mb-0">Please add statistics for the current season</p>
            </div>


        </div>
    @endif
</div>
