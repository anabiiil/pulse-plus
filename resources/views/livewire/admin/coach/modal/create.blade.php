<div>
    <div class="modal fade" id="create_coach" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create Coach</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="form" wire:submit.prevent="store" enctype="multipart/form-data">

                    <div class="modal-body">
                        <div class="row g-9 mb-8">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">
                                        First Name En
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" wire:model.live="first_name.en"
                                           class="form-control form-control-solid
                                        @error('first_name.en') is-invalid @enderror"
                                           name="name"
                                           placeholder=""/>
                                    @error("first_name.en")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 fv-row ">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">
                                       First Name Ar
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" wire:model.live="first_name.ar"
                                           class="form-control form-control-solid
                                        @error('first_name.ar') is-invalid @enderror"
                                           name="name"
                                           placeholder=""/>
                                    @error("first_name.ar")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-6 fv-row mt-2">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row ">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">
                                        Last Name En
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" wire:model.live="last_name.en"
                                           class="form-control form-control-solid
                                        @error('last_name.en') is-invalid @enderror"
                                           name="name"
                                           placeholder=""/>
                                    @error("last_name.en")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">
                                        Last Name Ar
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" wire:model.live="last_name.ar"
                                           class="form-control form-control-solid
                                        @error('last_name.ar') is-invalid @enderror"
                                           name="name"
                                           placeholder=""/>
                                    @error("last_name.ar")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

                            <div class="col-md-12 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">Image</label>
                                    <!--end::Label-->
                                    <input type="file" wire:model.live="image"
                                           class="form-control form-control-solid
                                        @error('image') is-invalid @enderror"
                                           placeholder="" />
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

