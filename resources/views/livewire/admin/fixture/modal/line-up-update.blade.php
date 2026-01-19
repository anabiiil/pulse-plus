<div>
    <div class="modal fade" id="update_lineup" wire:ignore.self data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Update lineup</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="modal-body row">

                        <div class="{{ isset($lineup) &&  $lineup->type == 'main' ? 'col-xl-6 col-lg-6  col-md-6 col-sm-12' : 'col-xl-12 col-lg-12  col-md-12 col-sm-12' }} mb-2">
                            <label for="product-gender-add" class="form-label">Player</label>
                            <select wire:model.live="player_id" class="form-control" >
                                <option value="">Select</option>
                                @if($players)
                                @foreach ($players as $player)
                                <option value="{{ $player->id }}" @if($player_id == $player->id ) selected @endif >{{ $player->name }} - ({{ $player->position }})</option>
                                @endforeach
                                @endif
                            </select>
                            @error('player_id')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        @if(isset($lineup))
                        @if($lineup->type == 'main')
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                            <label for="position" class="form-label">Is Captain</label>
                            <select wire:model="is_captain" class="form-control" id="position">
                                <option value="1">Yes</option>
                                <option selected value="0">No</option>
                            </select>
                            @error('is_captain')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                        @endif
                    </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
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
