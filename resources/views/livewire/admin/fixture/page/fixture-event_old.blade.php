@php use App\Models\Player;use Carbon\Carbon;use Illuminate\Support\Str; @endphp
<div>
    <div class="h5">
        Events
    </div>
    <div class="container mb-8">
        <ul class="timeline list-unstyled">
            @foreach($events_list as $ev)
                <li>
                    <div class="timeline-time text-end">
                        <span class="date">{{ Carbon::parse($ev->created_at)->format('j F Y') }}</span>
                        <span class="time d-inline-block">{{ $ev->match_time_min ?? 0 }}'</span>
                    </div>
                    <div class="timeline-icon">
                        <a href="javascript:void(0);"></a>
                    </div>
                    <div class="timeline-body">
                        <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                            <div class="flex-fill">
                                <div class="d-flex align-items-center">
                                    <div class="mt-sm-0 mt-2">
                                        <p class="mb-0 fs-14 fw-semibold"><img width="16px" alt="{{$ev->event_name}}"
                                                                               class="me-1"
                                                                               src="{{ asset('assets/images/event_icons/'.$ev->event_name.'.png') }}"> {{ Str::ucfirst(Str::replace('_',' ',$ev->event_name)) }}
                                        </p>
                                        @if($ev->player)
                                            <p class="mb-0 fs-14 fw-semibold">{{ $ev->player?->name }}
                                                - {{ $ev->player?->position?->value }}
                                                ({{ $ev->player?->current_club?->name }})</p>
                                        @endif

                                        @if($ev->extra_data['assist_id'] ?? null)
                                            <p class="mb-0 fs-13">assist
                                                : {{ Player::find($ev->extra_data['assist_id'])?->name }}</p>
                                        @endif
                                        @if($ev->extra_data['player_in_id'] ?? null)
                                            <p class="mb-0 fs-13">in
                                                : {{ Player::find($ev->extra_data['player_in_id'])?->name }}
                                                ({{ Player::find($ev->extra_data['player_in_id'])?->position?->value }}
                                                )</p>
                                        @endif

                                    </div>
                                    {{--                                    <div class="ms-auto">--}}
                                    {{--                                                <span class="float-end badge bg-light text-muted timeline-badge">--}}

                                    {{--                                                </span>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

    </div>


    <div class="h5">
        Select Event
    </div>
    <div class="my-4">
        <div class="d-flex">

            @if((count($events_list) > 0 && !$events_list->contains('event_name','start')) || !count($events_list))
                <div wire:click.prevent="add_event('start')" class="btn btn-outline-secondary btn-hover-animate mx-1">
                    Start
                    Match
                </div>
            @endif

            @if((count($events_list) > 0 && !$events_list->contains('event_name','break')))
                <div wire:click.prevent="add_event('break')"
                     class="btn btn-outline-primary btn-hover-animate  mx-1">Break
                </div>
            @endif


            @if((count($events_list) > 0 && !$events_list->contains('event_name','final')))
                <div wire:click.prevent="add_event('final')" class="btn btn-outline-success btn-hover-animate  mx-1">End
                    Match
                </div>
            @endif
            <div wire:click.prevent="add_event('substitute')" class="btn btn-outline-warning btn-hover-animate  mx-1">
                Substitute
            </div>

            {{--        <button type="button" class="btn btn-outline-primary" wire:click.prevent="add_event">Add Event</button>--}}
        </div>
        <div class="mt-4 mb-4">
            <div class="d-flex">

                <div wire:click.prevent="add_event('goal')" class="btn btn-success btn-hover-animate  mx-1">Goal</div>
                <div wire:click.prevent="add_event('penalty_goal')" class="btn btn-success btn-hover-animate  mx-1">
                    Penalty Goal
                </div>
                <div wire:click.prevent="add_event('penalty_won')"
                     class="btn btn-outline-success btn-hover-animate  mx-1">Penalty Won
                </div>

{{--                <div wire:click.prevent="add_event('penalty_save')"--}}
{{--                     class="btn btn-success-light btn-hover-animate  mx-1">Penalty Save--}}
{{--                </div>--}}

                <div wire:click.prevent="add_event('penalty_miss')"
                     class="btn btn-danger-light btn-hover-animate  mx-1">Penalty Miss
                </div>

                <div wire:click.prevent="add_event('own_goal')" class="btn btn-outline-danger btn-hover-animate  mx-1">
                    Own
                    Goal
                </div>


            </div>
            <div class="mt-4 mb-4">
                <div class="d-flex">

                    <div wire:click.prevent="add_event('var')" class="btn btn-secondary-light btn-hover-animate  mx-1">
                        Var
                    </div>
                    <div wire:click.prevent="add_event('save')" class="btn btn-success-light btn-hover-animate  mx-1">
                        Save
                    </div>


                    <div wire:click.prevent="add_event('yellow_card')"
                         class="btn bg-warning btn-hover-animate text-white mx-1">
                        Yellow Card
                    </div>
                    <div wire:click.prevent="add_event('red_card')"
                         class="btn bg-danger btn-hover-animate text-white mx-1">
                        Red
                        Card
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <div class="container">
            @foreach($events as $key => $event)
                <div>
                    @if(!in_array($event['event_type'],['start','final','break']))
                        <div
                            style="margin: 15px 0;font-weight: bold">{{ Str::replace('_',' ',$event['event_type']) }}</div>
                    @endif
                    <div class="row mb-2">
                        @if(in_array($event['event_type'],['start','final','break']))
                            <div class="form-group col-md-6">
                                <label class="fw-bold">{{ $event['event_type'] }}</label>
                                <input class="form-control w-50" wire:model="events.{{$key}}.event_type" disabled/>
                            </div>
                        @endif



                        @if(in_array($event['event_type'],['yellow_card','red_card','goal','penalty_goal','own_goal','save','penalty_won','penalty_save','penalty_miss']))
                            <div class="form-group col-md-3">
                                <label class="fw-bold">Select Player</label>
                                <select class="form-control select2 select_player"
                                        wire:model="events.{{$key}}.player_id">
                                    <option value="">select player</option>
                                    @foreach($lineup_players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }} -
                                            ({{ $player->position?->value }}) ({{ $player->current_club?->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            @if(in_array($event['event_type'],['goal','penalty_goal','own_goal','substitute']))
                                <div class="form-group col-md-3">
                                    <label class="fw-bold">Select sub player</label>
                                    <select class="form-control select2 select_player"
                                            wire:model="events.{{$key}}.event_sub_player">
                                        <option value="">select player</option>
                                        @foreach($lineup_players as $player)
                                            <option value="{{ $player->id }}">{{ $player->name }} -
                                                ({{ $player->position?->value }}) ({{ $player->current_club?->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="form-group col-md-3">
                                <label class="fw-bold">Event Minute</label>
                                <input type="text" class="form-control" wire:model="events.{{$key}}.event_minute">
                            </div>
                        @endif

                        @if(in_array($event['event_type'],['substitute']))
                            <div class="form-group col-md-3">
                                <label class="fw-bold">Select Player</label>
                                <select class="form-control select2" wire:change="set_replaced_player({{ $key }})"
                                        wire:model="events.{{$key}}.player_id">
                                    <option value="">select player</option>
                                    @foreach($lineup_players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }} -
                                            ({{ $player->position?->value }}) ({{ $player->current_club?->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group col-md-3">
                                <label class="fw-bold">Select replaced player</label>
                                <select class="form-control select2 select_player"
                                        wire:model="events.{{$key}}.event_sub_player">
                                    <option value="">select player</option>
                                    @foreach($replaced_players as $player)
                                        <option value="{{ $player->id }}">{{ $player->name }} -
                                            ({{ $player->position?->value }}) ({{ $player->current_club?->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="fw-bold">Event Minute</label>
                                <input type="text" class="form-control" wire:model="events.{{$key}}.event_minute">
                            </div>
                        @endif


                        <div class="form-group col-md-1">
                            <label style="visibility: hidden">{{ $event['event_type'] }}</label>
                            <button type="button" class="btn btn-danger"
                                    wire:click.prevent="remove_event({{$key}})"> -
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach

            <div class="text-center" style="margin-top:100px">
                <button type="button" class="btn btn-primary" wire:click.prevent="store_events">Add Events</button>
            </div>
        </div>
    </div>

</div>
@push('css')
    <style>
        .timeline > li {
            padding: 0;
            margin-bottom: 10px;
            padding-top: 5px;
        }

        .timeline li:before {
            height: 20px;
        }
    </style>

@endpush
@push('js')
    <script>
        $(document).ready(function () {
            $('#selectCountry').change(function () {
                let val = $(this).val();
                @this.
                set('country_id', val)
            })
        });
    </script>
@endpush
