<div>
    <div class="modal fade" id="create_club" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create Club</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">English Name</label>
                                <input type="text" wire:model.defer="name.en" name="name.en" class="form-control  @error('name') is-invalid @enderror
                                @error('name.en') is-invalid @enderror" placeholder="Enter English Name">
                                @error('name.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Arabic Name</label>
                                <input type="text" wire:model.defer="name.ar" name="name.ar" class="form-control  @error('name') is-invalid @enderror
                                @error('name.ar') is-invalid @enderror" placeholder="Enter Arabic Name">
                                @error('name.ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Official Name</label>
                                <input type="text" wire:model.defer="official_name" name="official_name"
                                       class="form-control  @error('official_name') is-invalid @enderror"
                                       placeholder="Enter Official Name">
                                @error('official_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Code</label>
                                <input type="text" wire:model.defer="code" name="code"
                                       class="form-control  @error('code') is-invalid @enderror"
                                       placeholder="Enter Code">
                                @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Image</label>
                                <input type="file" wire:model.defer="image" name="image"
                                       class="form-control  @error('image') is-invalid @enderror">
                                @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">T-Shirt Image</label>
                                <input type="file" wire:model.defer="t_shirt_image" name="t_shirt_image"
                                       class="form-control  @error('t_shirt_image') is-invalid @enderror">
                                @error('t_shirt_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">
                                    Country
                                </label>

                                <select wire:model="country_id"
                                        class="form-select form-control @error('country_id') is-invalid @enderror">
                                    <option>Select Country</option>

                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach

                                </select>
                                @error('country_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">English Stadium</label>
                                <input type="text" wire:model.defer="stadium.en" name="stadium.en" class="form-control  @error('stadium') is-invalid @enderror
                                @error('stadium.en') is-invalid @enderror" placeholder="Enter English Stadium">
                                @error('stadium.en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('stadium')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Arabic Stadium</label>
                                <input type="text" wire:model.defer="stadium.ar" name="stadium.ar" class="form-control  @error('stadium') is-invalid @enderror
                                @error('stadium.ar') is-invalid @enderror" placeholder="Enter Arabic Stadium">
                                @error('stadium.ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('stadium')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        @if($club_type)
                            <input type="text" hidden wire:model.defer="club_type">
                        @endif
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
