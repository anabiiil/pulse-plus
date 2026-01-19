<div>
    <div wire:ignore.self class="modal fade" id="add_bonus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                        <label for="input-text" class="form-label">Bouns Point</label>
                        <input type="number" wire:model.defer="event_value" min="0" max="3" name="event_value" class="form-control  @error('event_value') is-invalid @enderror
                        @error('event_value') is-invalid @enderror" placeholder="Enter Arabic title">
                        @error('event_value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Discard</button>

                        <button type="button" class="btn btn-success me-10" wire:click="store">
                            <span class="indicator-label" wire:loading.class="d-none" wire:target="store">
                                Save
                            </span>
                            <span class="d-none" wireloading:.class.remove="d-none" wire:target="store">
                                Wait <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
