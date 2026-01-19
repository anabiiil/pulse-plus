<div>
    <div class="modal fade" id="update_icon_category" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Update Icon Category</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">English Name</label>
                                <input type="text" wire:model.defer="name.en" name="name.en"
                                       class="form-control  @error('name') is-invalid @enderror
                                @error('name.en') is-invalid @enderror"
                                       placeholder="Enter English Name">
                                @error('name.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Arabic Name</label>
                                <input type="text" wire:model.defer="name.ar" name="name.ar"
                                       class="form-control  @error('name') is-invalid @enderror
                                @error('name.ar') is-invalid @enderror"
                                       placeholder="Enter Arabic Name">
                                @error('name.ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

