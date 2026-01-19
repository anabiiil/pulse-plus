<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body add-products p-0">
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="p-4">

                        <div class="row gx-5">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12">
                                <div class="card custom-card shadow-none mb-0 border-0">
                                    <div class="card-body p-0">
                                        <div class="row gy-3">
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-name-add" class="form-label"> Name</label>
                                                <input wire:model="name" type="text" class="form-control"
                                                       id="product-name-add" placeholder="Name">
                                                <label for="product-name-add"
                                                       class="form-label mt-1 fs-12 op-5 text-muted mb-0">*Player Name
                                                    should not exceed 30 characters</label>
                                                @error('name')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="selectCountry" class="form-label">Country</label>
                                                <div wire:ignore>
                                                    <select class="form-control select2"
                                                            id="selectCountry">
                                                        <option value="">Country</option>
                                                        @foreach ($countries as $country)
                                                            <option
                                                                value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('country_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-gender-add" class="form-label">Season</label>
                                                <select wire:model="season_id" class="form-control"
                                                        id="product-gender-add">
                                                    <option value="">Select</option>
                                                    @foreach ($seasons as $season)
                                                        <option value="{{ $season->id }}">{{ $season->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('season_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-cost-add" class="form-label">First Name</label>
                                                <input wire:model="first_name" type="text" class="form-control"
                                                       id="product-cost-add" placeholder="First Name">
                                                @error('first_name')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-cost-add" class="form-label">Last Name</label>
                                                <input wire:model="last_name" type="text" class="form-control"
                                                       id="product-cost-add" placeholder="Last Name">
                                                @error('last_name')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-type" class="form-label">Name in Match</label>
                                                <input wire:model="name_in_match" type="text" class="form-control"
                                                       id="product-type" placeholder="Name in Match">
                                                @error('name_in_match')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-discount" class="form-label">Price</label>
                                                <input wire:model="price" step="0.001" min="0" type="number"
                                                       class="form-control" id="product-discount1" placeholder="price">
                                                @error('price')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="publish-date" class="form-label">T_shirt</label>
                                                <input wire:model="t_shirt" type="text" class="form-control"
                                                       id="publish-date" placeholder="T_shirt">
                                                @error('t_shirt')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-status-add1" class="form-label">Position</label>
                                                <select wire:model="position" class="form-control"
                                                        id="product-status-add1">
                                                    <option value="">Select</option>
                                                    @foreach ($positions as $k => $p)
                                                        <option value="{{ $k }}">{{ $p }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('position')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-status-add" class="form-label">Player Status</label>
                                                <select wire:model="player_status" class="form-control"
                                                        id="product-status-add">
                                                    <option value="">Select</option>
                                                    @foreach ($statuses as $b => $s)
                                                        <option value="{{ $b }}">{{ $s }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('player_status')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="selectClub" class="form-label">Club</label>
                                                <div wire:ignore>
                                                    <select id="selectClub" class="form-control select2">
                                                        <option value="">Select Club</option>
                                                        @foreach ($clubs as $club)
                                                            <option value="{{ $club->id }}">{{ $club->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('current_club_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-status-add" class="form-label">national team</label>
                                                <select wire:model="national_team_id" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ($national_teams as $national_team)
                                                        <option
                                                            value="{{ $national_team->id }}">{{ $national_team->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('national_team_id')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-cost-add" class="form-label">Image</label>
                                                <input wire:model="image" type="file" class="form-control">

                                                @error('image')
                                                <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>


                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3  border-block-start-dashed d-sm-flex justify-content-end">


                        <button type="submit" class="btn btn-primary-light m-1">
                                <span class="indicator-label" wire:loading.class="d-none">
                                    Save <i class="bi bi-plus-lg ms-2"></i>
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
<!--End::row-1 -->

@push('js')
    <script>
        $(document).ready(function () {
            $('#selectCountry').change(function () {
                let val = $(this).val();
                @this.
                set('country_id', val)
            })
        });

        $(document).ready(function () {
            $('#selectClub').change(function () {
                let val = $(this).val();
                @this.
                set('current_club_id', val)
            })
        });
    </script>

@endpush
