<div>
    <div class="modal fade" id="update_country" wire:ignore.self
         data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel">Update Country</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row gx-5">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6">
                                <div class="card custom-card shadow-none mb-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">


                                            <div class="col-xl-6">
                                                <label for="category-img"
                                                       class="form-label text-black">Name (English)</label>
                                                <input type="text" class="form-control" wire:model="name.en">

                                                @error("name.en") <span
                                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="category-img"
                                                       class="form-label text-black">Name (Arabic)</label>
                                                <input type="text" class="form-control" wire:model="name.ar">

                                                @error("name.ar") <span
                                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-xl-6">
                                                <label for="category-img"
                                                       class="form-label text-black">Code</label>
                                                <input type="text" class="form-control" wire:model="code">

                                                @error("code") <span
                                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                                data-bs-dismiss="modal">Close
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
