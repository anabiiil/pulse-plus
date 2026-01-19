<div>

    <div class="my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Search</label>
                    <input wire:model.live="search" class="form-control">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Club</label>
                    <select wire:model.live="club_id" class="form-control">
                        <option value="">Select Club</option>
                        <option value="no_club">No Club</option>
                        @foreach($clubs as $club)
                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Player Status</label>
                    <select wire:model.live="player_status" class="form-control">
                        <option value="">Player Status</option>
                        @foreach($statuses as $st)
                            <option value="{{ $st }}">{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Positions</label>
                    <select wire:model.live="position" class="form-control">
                        <option value="">Select Position</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos }}">{{ $pos }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label>Price</label>
                    <input wire:model.live="price" class="form-control">
                </div>
            </div>


            <div class="col-md-2 mt-4">
                <div class="form-group">
                    <label>Sort By</label>
                    <select wire:model.live="sort_by" class="form-control">
                        <option value="name">Name</option>
                        <option value="price">price</option>
                        <option value="position">Position</option>
                        <option value="player_status">Status</option>
                        <option value="id">Id</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2  mt-4">
                <div class="form-group">
                    <label>Sort Type</label>
                    <select wire:model.live="sort_type" class="form-control">
                        <option value="asc">Asc</option>
                        <option value="desc">Desc</option>
                    </select>
                </div>
            </div>

            <div class="col-md-8">
                <div class="form-group text-end">
                    <label class="d-block" style="visibility: hidden">Reset</label>
                    <button class="btn btn-danger" type="button" wire:click.prevent="resetData">Reset</button>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-2">
            <div class="table-responsive">
                <table class="table text-nowrap table-bordered">
                    <thead>
                    <tr>
                        {{--                        <th class="text-center" scope="col">Index</th>--}}
                        <th class="text-center" scope="col">Player Id</th>
                        <th class="text-center" scope="col">Image</th>
                        <th class="text-center" scope="col">Name In Match</th>
                        <th class="text-center" scope="col">T-Shirt</th>
                        <th class="text-center" scope="col">Price</th>
                        <th class="text-center" scope="col">Position</th>
                        <th class="text-center" scope="col">CLub</th>
                        <th class="text-center" scope="col">Country</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all as $element)
                        <tr wire:key="player-{{ $element->id }}">
                            {{--                            <td class="text-center">{{ $element->index }}</td>--}}
                            <td class="text-center"> {{ $element->id }}</td>
                            <td class="text-center">
                                <livewire:admin.player.table.image :row="$element" wire:key="{{ $element->api_id }}"/>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.player.show', $element->id) }}"
                                   class="btn btn-link text-decoration-none">{{ $element->name_in_match ?? '---' }}</a>
                            </td>
                            <td class="text-center"> {{ $element->t_shirt ?? '---' }}</td>
                            <td class="text-center"> {{ $element->price ?? '---' }}</td>
                            <td class="text-center"> {{ $element->position?->value ?? '---' }}</td>
                            <td class="text-center"> {{ $element->current_club?->name ?? '---' }}</td>
                            <td class="text-center"> {{ $element?->country?->name ?? "---" }}</td>

                            <td class="text-center"><span
                                    class="badge badge- {{ $element->player_status?->color() }}">{{ $element->player_status?->trans() }}</span>
                            </td>
                            <td class="text-center">
                                <livewire:admin.player.table.action :row="$element"
                                                                    wire:key="{{ $element->id }}"/>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>


            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-end">
                    {{ $all->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
