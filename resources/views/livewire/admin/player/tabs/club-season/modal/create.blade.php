<div>
    <div class="modal fade" id="create_club_season" wire:ignore.self
         data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel"> Player Transfer Season</h6>
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


                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                                <label for="input-text" class="form-label">
                                                    Season
                                                </label>

                                                <select wire:model="season_id"
                                                        class="form-select form-control @error('season_id') is-invalid @enderror">
                                                    <option>Select season</option>

                                                    @foreach ($seasons as $season)
                                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('season_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-13 col-lg-13 col-md-12 col-sm-12 mb-2">
                                                <label for="input-text" class="form-label">
                                                    Club
                                                </label>

                                                <select wire:model="club_id"
                                                        class="form-select form-control @error('club_id') is-invalid @enderror">
                                                    <option>Select Club</option>

                                                    @foreach ($clubs as $club)
                                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('club_id')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-2">
                                                <label for="input-text" class="form-label">
                                                    Transfer
                                                </label>

                                                <select wire:model="transfer_in"
                                                        class="form-select form-control @error('transfer_in') is-invalid @enderror">
                                                    <option>Select Transfer</option>
                                                        <option value="winter">winter</option>
                                                        <option value="summer">summer</option>


                                                </select>
                                                @error('transfer_in')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
