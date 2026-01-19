<div>
    <div class="modal fade" id="update_competition" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Update Competition</h6>
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

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">
                                    Season
                                </label>

                                <select wire:model="season_id"
                                    class="form-select form-control @error('season_id') is-invalid @enderror">
                                    <option>Select Season</option>

                                    @foreach ($seasons as $season)
                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                    @endforeach

                                </select>
                                @error('season_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">English Description</label>
                                <textarea  wire:model.defer="description.en" name="description.en"
                                    class="form-control  @error('description') is-invalid @enderror
                                @error('description.en') is-invalid @enderror"
                                    placeholder="Enter English Description" rows="6"></textarea>
                                @error('description.en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Arabic Description</label>
                                <textarea  wire:model.defer="description.ar" name="description.ar"
                                    class="form-control  @error('description') is-invalid @enderror
                                @error('description.ar') is-invalid @enderror"
                                    placeholder="Enter Arabic Description" rows="6"></textarea>
                                @error('description.ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('description')
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
            </div>
        </div>
    </div>
</div>

</div>
