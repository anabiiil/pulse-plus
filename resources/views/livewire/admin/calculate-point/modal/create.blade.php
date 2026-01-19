<div>

    <div>
        <div class="modal fade" id="create_calculate_point" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel">Create Calculate Points</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <label for="input-text" class="form-label">English title</label>
                                    <input type="text" wire:model.defer="title.en" name="title.en" class="form-control  @error('title') is-invalid @enderror
                                    @error('title.en') is-invalid @enderror" placeholder="Enter English title">
                                    @error('title.en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                    <label for="input-text" class="form-label">Arabic title</label>
                                    <input type="text" wire:model.defer="title.ar" name="title.ar" class="form-control  @error('title') is-invalid @enderror
                                    @error('title.ar') is-invalid @enderror" placeholder="Enter Arabic title">
                                    @error('title.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
{{--                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                                    <label for="input-text" class="form-label">English Description</label>--}}
{{--                                    <textarea wire:model.defer="description.en" name="description.en" class="form-control  @error('description') is-invalid @enderror--}}
{{--                                @error('description.en') is-invalid @enderror" placeholder="Enter English Description"--}}
{{--                                              rows="6"></textarea>--}}
{{--                                    @error('description.en')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                    @error('description')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">--}}
{{--                                    <label for="input-text" class="form-label">Arabic Description</label>--}}
{{--                                    <textarea wire:model.defer="description.ar" name="description.ar" class="form-control  @error('description') is-invalid @enderror--}}
{{--                                    @error('description.ar') is-invalid @enderror"--}}
{{--                                              placeholder="Enter Arabic Description" rows="6"></textarea>--}}
{{--                                    @error('description.ar')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                    @error('description')--}}
{{--                                    <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                    <label for="input-text" class="form-label">Point</label>
                                    <input type="number" wire:model.defer="point" name="point" class="form-control  @error('point') is-invalid @enderror
                                    @error('point') is-invalid @enderror" placeholder="Enter Arabic title">
                                    @error('title.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
