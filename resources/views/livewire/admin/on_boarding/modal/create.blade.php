<div>
    <div class="modal fade" id="create_on_boarding" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create Onboarding</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->

                            <div class="col-xl-6">
                                <label for="category-img"
                                       class="form-label text-black">title (English)</label>
                                <input type="text" class="form-control" wire:model="title.en">

                                @error("title.en") <span
                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-xl-6">
                                <label for="category-img"
                                       class="form-label text-black">title (Arabic)</label>
                                <input type="text" class="form-control" wire:model="title.ar">

                                @error("title.ar") <span
                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                            </div>


                            <div class="col-xl-6">
                                <label for="category-img"
                                       class="form-label text-black">Desc (English)</label>
                                <textarea type="text" class="form-control" rows="6" wire:model="desc.en"></textarea>

                                @error("desc.en") <span
                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-xl-6">
                                <label for="category-img"
                                       class="form-label text-black">Desc (Arabic)</label>
                                <textarea type="text" class="form-control" rows="6" wire:model="desc.ar"></textarea>

                                @error("desc.ar") <span
                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-xl-6">
                                <label for="category-"
                                       class="form-label text-black">Order</label>
                                <input type="number" class="form-control" wire:model="order"/>

                                @error("order") <span
                                    class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-6">
                                <label>Select Type</label>
                                <select wire:model.live="type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="create_team">Create Team</option>
                                    <option value="home">Home</option>
                                </select>
                            </div>
                            <div class="col-md-12 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">Image</label>
                                    <!--end::Label-->
                                    <input type="file" wire:model.live="image"
                                           class="form-control form-control-solid
                                        @error('image') is-invalid @enderror"
                                           placeholder=""/>
                                    @error("image")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

