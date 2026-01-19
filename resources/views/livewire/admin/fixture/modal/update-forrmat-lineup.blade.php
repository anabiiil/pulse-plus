<div>
    <div class="modal fade" id="update_format_lineup" wire:ignore.self data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Update lineup format</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="modal-body row">

                        <div class="col-xl-12 col-lg-12  col-md-12 col-sm-12'  mb-2">
                            <label for="product-gender-add" class="form-label">Format</label>
                            <select wire:model.live="lineup_selected_lineup" class="form-control" >
                                <option value="">Select</option>
                                @foreach ($allFormats as $key =>  $format )
                                    <option value="{{  $key }}" @if($lineup_selected_lineup ==  $key ) selected @endif >{{ $key }}</option>
                                @endforeach
                            </select>
                            @error('player_id')
                            <span class="text-danger d-block mt-2">{{ $message }}</span>
                            @enderror
                        </div>

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
