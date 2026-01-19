<div>
    <div class="modal fade" id="create_icon" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create Icon</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row">


                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                <label for="input-text" class="form-label">Name</label>
                                <input type="text" wire:model.defer="name" name="name"
                                       class="form-control  @error('name') is-invalid @enderror"
                                       placeholder="Enter  Name">
                                @error('name')
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
                                <div class="form-group">
                                <label for="input-text" class="form-label">
                                    Icon Category
                                </label>

                                <select wire:model="icon_category_id"
                                        class="form-select form-control @error('icon_category_id') is-invalid @enderror"
                                >
                                    <option>Select Icon Category</option>
                                    @foreach ($icon_categories as $icon_category)
                                        <option value="{{ $icon_category->id }}">{{ $icon_category->name }}</option>
                                    @endforeach

                                </select>
                                </div>
                                @error('icon_category_id')
                                <div class="text-danger">{{ $message }}</div>
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

