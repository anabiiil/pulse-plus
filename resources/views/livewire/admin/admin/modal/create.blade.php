<div>
    <div class="modal fade" id="create_admin" wire:ignore.self data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Create Admin</h6>
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
                                      Name
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" wire:model.live="name"
                                           class="form-control form-control-solid
                                        @error('name') is-invalid @enderror"
                                           name="name"
                                           placeholder="Enter Admin Name"/>
                                    @error("name")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">Email
                                    </label>
                                    <!--end::Label-->
                                    <input type="email" wire:model.live="email"
                                           name="email"
                                           class="form-control form-control-solid
                                        @error('email') is-invalid @enderror"
                                           placeholder="Enter Admin Email"/>
                                    @error("email")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-6 fv-row">
                                <!--begin::Input group-->
                                <div class="d-flex flex-column mb-8 fv-row">
                                    <!--begin::Label-->
                                    <label for="input-text" class="form-label">Password</label>
                                    <!--end::Label-->
                                    <input type="password" wire:model.live="password"
                                           name="password"
                                           class="form-control form-control-solid
                                        @error('password') is-invalid @enderror"
                                           placeholder="Enter Admin Password"/>
                                    @error("password")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

