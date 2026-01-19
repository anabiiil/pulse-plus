<div>
    <div class="modal fade" id="create_lineup" wire:ignore.self data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create lineup</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="modal-body row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="position" class="form-label">Player position</label>
                            <select wire:model="position" wire:change="update_players($event.target.value)" class="form-control" id="position">
                                <option value="">Select</option>

                                @foreach ($positions as $k => $p)
                                <option value="{{ $k }}">{{ $p }}
                                </option>
                                @endforeach
                            </select>
                            @error('position')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="product-gender-add" class="form-label">Player</label>
                            <select wire:model="player_id" class="form-control" id="player_id">
                                <option value="">Select</option>
                                @if($players)
                                @foreach ($players as $player)
                                <option value="{{ $player->id }}">{{ $player->name }} - ({{ $player->position }})</option>
                                @endforeach
                                @endif
                            </select>
                            @error('player_id')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="position" class="form-label">Is Captain</label>
                            <select wire:model="is_captain" class="form-control" id="position">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                            @error('is_captain')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="type" class="form-label">Type</label>
                            <select wire:model="type" class="form-control" id="type">
                                <option value="">Select</option>
                                <option value="main">main</option>
                                <option value="sub">sub</option>
                            </select>
                            @error('type')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                <span class="indicator-label" wire:loading.class="d-none">
                                    Save
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
