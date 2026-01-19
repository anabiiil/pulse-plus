<div>

    <div >
        <div class="d-flex my-2 mx-2">
            @foreach(seasons() as $season)
            <button type="button" class="btn mx-1 {{ $season->id == $season_id ? 'btn-primary' : 'btn-outline-primary' }}" wire:click="getSeasonData({{$season->id}},{{$season->id}})"> Season {{ $season->name }}</button>
            @endforeach
        </div>
    </div>
    <div class="">
        <h4>Season {{ $activeSeason?->name }} Overall Points</h4>
    </div>
    <div class="table-responsive mt-4 mb-4">
        <table class="table text-nowrap table-bordered border-success">
            <thead>
            <tr>
                <th scope="col">#</th>

                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Total Points" class="text-primary">TP</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Total Goals" class="text-primary">TG</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Minutes Played" class="text-primary">MP</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Goals" class="text-primary">PG</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                    data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Won" class="text-primary">PW</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark">
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Miss" class="text-primary">PM</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark">Assist</span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Red Cards" class="text-primary">RD</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Yellow Cards" class="text-primary">YC</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Own Goal" class="text-primary">OG</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Clean Sheet" class="text-primary">CS</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Conceded" class="text-primary">PC</a></span></th>
                <th scope="col"><span class="badge bg-light text-dark">bonus</span></th>


            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">
                    statistics
                </th>

                <td>
                    <span class="badge bg-light text-dark">{{ $points->sum('points') }} P</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','goal')->sum('event_value') + $points->where('event_type','penalty_goal')->sum('event_value') }}  | ({{ $points->where('event_type','penalty_goal')->sum('points') +  $points->where('event_type','goal')->sum('points') }} P)</span>
                </td>


                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','minutes_played')->sum('event_value') }} | ({{ $points->where('event_type','minutes_played')->sum('points') }} P)</span>
                </td>

                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','penalty_goal')->sum('event_value') }}   | ({{ $points->where('event_type','penalty_goal')->sum('points') }} P)</span>
                </td>

                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','penalty_won')->sum('event_value') }}   | ({{ $points->where('event_type','penalty_won')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','penalty_miss')->sum('event_value') }}  | ({{ $points->where('event_type','penalty_miss')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','assist')->sum('event_value') }} | ({{ $points->where('event_type','assist')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','red_card')->sum('event_value') }} | ({{ $points->where('event_type','red_card')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','yellow_card')->sum('event_value') }} | ({{ $points->where('event_type','yellow_card')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','own_goal')->sum('event_value') }} | ({{ $points->where('event_type','goal')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','clean_sheet')->sum('event_value') }} | ({{ $points->where('event_type','clean_sheet')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','penalty_conceded')->sum('event_value') }} | ({{ $points->where('event_type','goal_conceded')->sum('points') }} P)</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">{{ $points->where('event_type','bonus')->sum('event_value') }} | ({{ $points->where('event_type','goal_conceded')->sum('points') }} P)</span>
                </td>

            </tr>


            </tbody>
        </table>
    </div>



    <div class="">
        <h4>Season {{ $activeSeason?->name }} Weeks Points</h4>
    </div>

    <div class="table-responsive mt-4">
        <table class="table text-nowrap table-bordered border-success">
            <thead>
                <tr>
                    <th scope="col">#</th>

                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Total Points" class="text-primary">TP</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Total Goals" class="text-primary">TG</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Minutes Played" class="text-primary">MP</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Goals" class="text-primary">PG</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Won" class="text-primary">PW</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark">
                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Miss" class="text-primary">PM</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark">Assist</span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Red Cards" class="text-primary">RD</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Yellow Cards" class="text-primary">YC</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Own Goal" class="text-primary">OG</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Clean Sheet" class="text-primary">CS</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Penalty Conceded" class="text-primary">PC</a></span></th>
                    <th scope="col"><span class="badge bg-light text-dark">bonus</span></th>


                </tr>
            </thead>
            <tbody>
            @foreach($weeks as $week)
                @php
                    $WeekPoint = $points->where('week_id',$week->id);
                @endphp
                <tr>
                    <th scope="row">
                        {{ $week->name }}
                    </th>

                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->sum('points') }} P</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','goal')->sum('event_value') + $WeekPoint->where('event_type','penalty_goal')->sum('event_value') }}  | ({{ $WeekPoint->where('event_type','penalty_goal')->sum('points') +  $WeekPoint->where('event_type','goal')->sum('points') }} P)</span>
                    </td>


                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','minutes_played')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','minutes_played')->sum('points') }} P)</span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','penalty_goal')->sum('event_value') }}   | ({{ $WeekPoint->where('event_type','penalty_goal')->sum('points') }} P)</span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','penalty_won')->sum('event_value') }}   | ({{ $WeekPoint->where('event_type','penalty_won')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','penalty_miss')->sum('event_value') }}  | ({{ $WeekPoint->where('event_type','penalty_miss')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','assist')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','assist')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','red_card')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','red_card')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','yellow_card')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','yellow_card')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','own_goal')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','goal')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','clean_sheet')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','clean_sheet')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','penalty_conceded')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','goal_conceded')->sum('points') }} P)</span>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">{{ $WeekPoint->where('event_type','bonus')->sum('event_value') }} | ({{ $WeekPoint->where('event_type','goal_conceded')->sum('points') }} P)</span>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</div>
