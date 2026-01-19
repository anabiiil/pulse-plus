<div>
    {{-- Start of the component --}}
    @if($fixture)
    <div class="d-flex justify-content-between">
        {{-- Home Club --}}
        <div class="me-1 lh-1">
            <div class="my-2">
                <span class="fontSize20 text-center my-1">{{ $fixture->homeClub?->name }}</span>
            </div>
            <div class="avatar avatar-sm avatar-rounded text-default">
                <img src="{{ $fixture->homeClub?->fileUrl }}" alt="Home Club">
            </div>
        </div>

        {{-- Away Club --}}
        <div class="ms-1 lh-1">
            <div class="fontSize20 text-center my-1">{{ $fixture->awayClub?->name }}</div>
            <div class="my-2">
                <span class="avatar avatar-sm avatar-rounded text-default">
                    <img src="{{ $fixture->awayClub?->fileUrl }}" alt="Away Club">
                </span>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        @if(count($lineups['home']) || count($lineups['away']))

        {{-- Home Lineup --}}
        @if($lineups['home']['main']->count() > 1 )
        @php
        $lineup = $lineups['home'];
        @endphp
        <div class="col-lg-6">
            <a wire:click="$dispatch('update_format_lineup' , {type:'home' })">
                <div class="row d-block">
                    <h3 class="text-center">{{ $fixture->home_lineup_format }}</h3>
                </div>
            </a>
            <div class="table-responsive  my-2">
                <table class="table  text-nowrap table-striped ">

                    <thead>
                        <tr>
                            <th scope="col">Player</th>
                            <th scope="col">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($lineup['main']->count() > 0 || $lineup['sub']->count() > 0)
                        <tr>
                            <td colspan="2" class="text-center bg-primary text-light">Main</td>
                        </tr>
                        @if($lineup['main']->count() > 0)
                        @foreach ($lineup['main'] as $player)

                        <tr>
                            <th wire:click.prevent="$dispatch('update_lineup' , {lineup_id:{{ $player?->id }} })" scope="row">{{ $player?->player?->name }}</th>
                            <td><span class="badge {{ $player?->positionColor($player?->player?->position->value) }} ">{{ $player?->position }}</span>
                                @if($player?->is_captain)
                                <img width="20px" src="{{ asset('assets/images/flags/captain.png') }}" alt="captain icon">
                                @endif
                                <span> ({{ $player?->player?->player_points()->where('fixture_id',$fixtuer->id)->sum('points') }} P) id: {{$player?->player?->id}}</span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="2" class="text-center bg-primary text-light">Sub</td>
                        </tr>
                        @if($lineup['sub']->count() > 0)
                        @foreach ($lineup['sub'] as $player)

                        <tr>

                            <th wire:click.prevent="$dispatch('update_lineup' , {lineup_id:{{ $player?->id }} })" scope="row">{{ $player?->player?->name }} </th>
                            <td>
                                <span class="badge {{ $player?->positionColor($player?->player?->position->value) }}">{{ $player?->position }} </span>
                                <span> ({{ $player?->player?->player_points()->where('fixture_id',$fixtuer->id)->sum('points') }} P) id: {{$player?->player?->id}}</span>
                            </td>

                        </tr>

                        @endforeach
                        @endif

                        @else
                        <tr>
                            <td colspan="2" class="text-center bg-danger text-light">No Players Please add</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

        @else
        <div class="col-lg-6 justify-content-center align-items-center">
            @if (!$isHomeLineupVisible)
            <button class="btn btn-success" wire:click="toggleHomeLineup">Add Lineup for Home</button>
            @endif
            @if ($isHomeLineupVisible)

            <div class="col-lg-12 d-flex justify-content-center">
                <select class="form-control select format_lineup_home" wire:model.live="format_lineup_home" wire:change="update_fixture_home_format($event.target.value)">
                    <option value="">Select Format</option>
                    @foreach ($format_all as $key => $value)
                    <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            @if ($format_lineup_home)
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col-3" colspan="3">player</th>
                                <th scope="col">position</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- main --}}
                            <tr>
                                <td colspan="4" class="text-center bg-primary text-light">Main</td>
                            </tr>
                            @foreach ($format_all[$format_lineup_home] as $key => $value)

                            <tr>
                                @if($value == '00')
                                <th scope="row-3" colspan="3">
                                    <select class="form-control select add_player_home" data-element="{{ $value }}" wire:change="add_player_to_lineup_home($event.target.value , '{{ $value }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersHomeGk->count() > 0)
                                        @foreach ($AllPlayersHomeGk as $player)
                                        @if(!in_array($player?->id, $lineup_selected_lineup_home) || isset($lineup_selected_lineup_home[$value]))
                                        <option value="{{ $player?->id }}">{{ $player?->name }} - {{ $player?->position }} </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </th>
                                @else
                                <th scope="row-3" colspan="3">
                                    <select class="form-control select add_player_home" data-element="{{ $value }}" wire:change="add_player_to_lineup_home($event.target.value , '{{ $value }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersHomeNotGk->count() > 0)
                                        @foreach ($AllPlayersHomeNotGk as $player)
                                        @if(!in_array($player?->id, $lineup_selected_lineup_home) || isset($lineup_selected_lineup_home[$value]))
                                        <option value="{{ $player?->id }}">{{ $player?->name }} - {{ $player?->position }} </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </th>
                                @endif
                                <td>{{ $postions[$value[0]] }}</td>

                            </tr>
                            @endforeach

                            {{-- sub --}}
                            <tr>
                                <td colspan="4" class="text-center bg-primary text-light">Sub</td>
                            </tr>
                            @for( $i = 0 ; $i < 7 ; $i++ ) <tr>
                                <th scope="row-3" colspan="4">
                                    <select class="form-control select add_player_home" data-element="sub_{{ $i }}" wire:change="add_player_to_lineup_home($event.target.value , 'sub_{{ $i }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersHome->count() > 0)
                                        @foreach ($AllPlayersHome as $player)
                                        @if((!in_array("$player?->id-".$player?->position->value, $lineup_selected_lineup_home) && !in_array($player?->id, $lineup_selected_lineup_home)) || isset($lineup_selected_lineup_home["sub_$i"]))
                                        <option value="{{ $player?->id }}-{{ $player?->position }}">{{ $player?->name }} - {{ $player?->position }} </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </th>
                                </tr>
                                @endfor
                                <tr>
                                    {{-- save action   --}}
                                    <td colspan="4">
                                        <button class="btn btn-success" wire:click="save_lineup_home">Save Lineup</button>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
        @endif

        @if($lineups['away']['main']->count() > 1 )
        @php
        $lineup = $lineups['away'];
        @endphp
        <div class="col-lg-6">
            <a wire:click="$dispatch('update_format_lineup' , {type:'away' })">
                <div class="row d-block">
                    <h3 class="text-center" wire:click.prevent="$dispatch('update_format_lineup' , {type:'away'})">{{ $fixture->away_lineup_format }}</h3>
                </div>
            </a>
            <div class="table-responsive  my-2">
                <table class="table  text-nowrap table-striped ">

                    <thead>
                        <tr>
                            <th scope="col">Player</th>
                            <th scope="col">Position</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($lineup['main']->count() > 0 || $lineup['sub']->count() > 0)
                        <tr>
                            <td colspan="2" class="text-center bg-primary text-light">Main</td>
                        </tr>

                        @if($lineup['main']->count() > 0)
                        @foreach ($lineup['main'] as $player)

                        <tr>
                            <th wire:click.prevent="$dispatch('update_lineup' , {lineup_id:{{ $player?->id }} })" scope="row">{{ $player?->player?->name }}</th>
                            <td><span class="badge {{ $player?->positionColor($player?->player?->position->value) }} ">{{ $player?->position }}</span>
                                @if($player?->is_captain)
                                <img width="20px" src="{{ asset('assets/images/flags/captain.png') }}" alt="captain icon">
                                @endif
                                <span> ({{ $player?->player?->player_points()->where('fixture_id',$fixtuer->id)->sum('points') }} P) id: {{$player?->player?->id}}</span>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="2"  class="text-center bg-primary text-light">Sub</td>
                        </tr>
                        @if($lineup['sub']->count() > 0)
                        @foreach ($lineup['sub'] as $player)
                        <tr>
                            <th wire:click.prevent="$dispatch('update_lineup' , {lineup_id:{{ $player?->id }} })" scope="row">{{ $player?->player?->name }} </th>
                            <td>
                                <span class="badge {{ $player?->positionColor($player?->player?->position->value) }}">{{ $player?->position }} </span>

                                <span> ({{ $player?->player?->player_points()->where('fixture_id',$fixtuer->id)->sum('points') }} P) id: {{$player?->player?->id}}</span>
                            </td>
                        </tr>
                        @endforeach
                        @endif

                        @else
                        <tr>
                            <td colspan="2" class="text-center bg-danger text-light">No Players Please add</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
        @else
        {{-- Away Lineup --}}
        <div class="col-lg-6 justify-content-center align-items-center">
            @if (!$isAwayLineupVisible)
                <button class="btn btn-success" wire:click="toggleAwayLineup">Add Lineup for Away</button>
            @endif
            @if ($isAwayLineupVisible)
            <div class="col-lg-12 d-flex justify-content-center">
                <select class="form-control  format_lineup_away" data-element="format_lineup_away" wire:model.live="format_lineup_away" wire:change="update_fixture_away_format($event.target.value)">
                    <option value="">Select Format</option>
                    @foreach ($format_all as $key => $value)
                    <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                </select>
            </div>
            @if ($format_lineup_away)
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">player</th>
                                <th scope="col">position</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- main --}}
                            <tr>
                                <td colspan="4" class="text-center bg-primary text-light">Main</td>
                            </tr>
                            @foreach ($format_all[$format_lineup_away] as $value)
                            <tr>
                                @if($value == '00')
                                <th scope="row">
                                    <select class="form-control add_player_away " data-element="{{ $value }}" wire:change="add_player_to_lineup_away($event.target.value , '{{ $value }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersAwayGk->count() > 0)
                                            @foreach ($AllPlayersAwayGk as $player)
                                                @if(!in_array($player?->id, $lineup_selected_lineup_away) || isset($lineup_selected_lineup_away[$value]))
                                                    <option value="{{ $player?->id }}">{{ $player?->name }} - {{ $player?->position }} </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                                @else
                                <th scope="row">
                                    <select class="form-control add_player_away " data-element="{{ $value }}" wire:change="add_player_to_lineup_away($event.target.value , '{{ $value }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersAwayNotGk->count() > 0)
                                            @foreach ($AllPlayersAwayNotGk as $player)
                                                @if(!in_array($player?->id, $lineup_selected_lineup_away) || isset($lineup_selected_lineup_away[$value]))
                                                    <option value="{{ $player?->id }}">{{ $player?->name }} - {{ $player?->position }} </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                                @endif
                                <td>{{ $postions[$value[0]] }}</td>
                            </tr>
                            @endforeach
                            {{-- sub --}}
                            <tr>
                                <td colspan="4" class="text-center bg-primary text-light">Sub</td>
                            </tr>
                            @for( $i = 0 ; $i < 7 ; $i++ ) <tr>
                                <th scope="row-3" colspan="4">
                                    <select class="form-control add_player_away" data-element="sub_{{ $i }}" wire:change="add_player_to_lineup_away($event.target.value , 'sub_{{ $i }}')">
                                        <option value="">Select player</option>
                                        @if($AllPlayersAway->count() > 0)
                                            @foreach ($AllPlayersAway as $player)
                                                @if((!in_array("$player?->id-".$player?->position->value, $lineup_selected_lineup_away) && !in_array($player?->id, $lineup_selected_lineup_away)) || isset($lineup_selected_lineup_away["sub_$i"]))
                                                <option value="{{ $player?->id }}-{{ $player?->position }}">{{ $player?->name }} - {{ $player?->position}} </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </th>
                                </tr>
                                @endfor
                                <td colspan="4">
                                    <button class="btn btn-success" wire:click="save_lineup_away">Save Lineup</button>
                                </td>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endif
        </div>
        @endif
        <livewire:admin.fixture.modal.line-up-update />
        <livewire:admin.fixture.modal.update-forrmat-lineup :allFormats="$format_all" :fixture="$fixture" />
        @endif

    </div>
    {{-- lineup Modals --}}

    @push('js')
    <script>
        Livewire.on('update_format_lineup_select2', () => {
            // after load document
            $(document).ready(function() {
                $('.format_lineup_away').select2();
                $('.format_lineup_home').select2();
                $('.add_player_away').select2();
                $('.add_player_home').select2();
                $('.format_lineup_away').on('change', function(e) {
                    let element = $(this).data('element');
                    let value = $(this).val();
                    Livewire.dispatch('update_format_lineup_away', {
                        format: '4-4-2'
                    });
                });
                $('.format_lineup_home').on('change', function(e) {
                    let element = $(this).data('element');
                    let value = $(this).val();
                    Livewire.dispatch('update_format_lineup_home', {
                        format: '4-4-2'
                    });
                });
                $('.add_player_away').on('change', function(e) {
                    let element = $(this).data('element');
                    let value = $(this).val();
                    console.log(value)
                    Livewire.dispatch('add_player_to_lineup_away', {
                        player_id: value
                        , position: element
                    });
                });
                $('.add_player_home').on('change', function(e) {
                    let element = $(this).data('element');
                    let value = $(this).val();
                    console.log(value)
                    Livewire.dispatch('add_player_to_lineup_home', {
                        player_id: value
                        , position: element
                    });
                });

            });
        })

    </script>
    @endpush
    {{-- End of the component --}}
    {{-- lineup Modals --}}
    {{-- End of the component --}}
</div>
