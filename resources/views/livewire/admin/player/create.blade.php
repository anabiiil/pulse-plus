<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body add-products p-0">
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                <div class="p-4">

                    <div class="row gx-5">
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <label for="product-name-add" class="form-label"> Name</label>
                                            <input wire:model="name" type="text" class="form-control" id="product-name-add" placeholder="Name">
                                            <label for="product-name-add" class="form-label mt-1 fs-12 op-5 text-muted mb-0">*Player Name should not exceed 30 characters</label>
                                            @error("name") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="product-category-add" class="form-label">Nationality</label>
                                            <select wire:model="nationality_id" class="form-control"  id="product-category-add">
                                                <option value="">Nationality</option>
                                                @foreach($nationalities as $nationality)
                                                <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                                                @endforeach

                                            </select>
                                            @error("nationality_id") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="product-gender-add" class="form-label">Season</label>
                                            <select wire:model="season_id" class="form-control"  id="product-gender-add">
                                                <option value="">Select</option>
                                                @foreach($seasons as $season)
                                                    <option value="{{$season->id}}">{{$season->name}}</option>
                                                @endforeach
                                            </select>
                                            @error("season_id") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-xl-6">
                                            <label for="product-cost-add" class="form-label">First Name</label>
                                            <input wire:model="first_name" type="text" class="form-control" id="product-cost-add" placeholder="First Name">
                                            @error("first_name") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-xl-6">
                                            <label for="product-cost-add" class="form-label">Last Name</label>
                                            <input wire:model="last_name" type="text" class="form-control" id="product-cost-add" placeholder="Last Name">
                                            @error("last_name") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-xl-12">
                                            <label for="product-cost-add" class="form-label">Image</label>
                                            <input wire:model="image" type="file" class="form-control" >
                                            @error("image") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-12 col-lg-12 col-md-6">
                            <div class="card custom-card shadow-none mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="row gy-4">

                                        <div class="col-xl-6">
                                            <label for="product-type" class="form-label">Name in Match</label>
                                            <input wire:model="name_in_match" type="text" class="form-control" id="product-type" placeholder="Name in Match">
                                            @error("name_in_match") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="product-discount" class="form-label">Price</label>
                                            <input wire:model="price" step="0.001" min="0" type="number" class="form-control" id="product-discount1" placeholder="price">
                                            @error("price") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="publish-date" class="form-label">T_shirt</label>
                                            <input wire:model="t_shirt" type="text" class="form-control" id="publish-date" placeholder="T_shirt">
                                            @error("t_shirt") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="product-status-add1" class="form-label">Position</label>
                                            <select wire:model="position" class="form-control"  id="product-status-add1">
                                                <option value="">Select</option>
                                                @foreach($positions as $k=>$p)
                                                    <option value="{{$k}}">{{$p}}</option>
                                                @endforeach
                                            </select>
                                            @error("position") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="product-status-add" class="form-label">Player Status</label>
                                            <select wire:model="player_status" class="form-control"  id="product-status-add">
                                                <option value="">Select</option>
                                                @foreach($statuses as $b=>$s)
                                                <option value="{{$b}}">{{$s}}</option>
                                                @endforeach
                                            </select>
                                            @error("player_status") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="col-xl-12">
                                            <label for="product-status-add" class="form-label">Club</label>
                                            <select wire:model="current_club_id" class="form-control"  >
                                                <option value="">Select</option>
                                                @foreach($clubs as $club)
                                                    <option value="{{$club->id}}">{{$club->name}}</option>
                                                @endforeach
                                            </select>
                                            @error("current_club_id") <span
                                                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="px-4 py-3 border-top border-block-start-dashed d-sm-flex justify-content-end">



                    <button type="submit" class="btn btn-primary-light m-1">
                                <span class="indicator-label" wire:loading.class="d-none">
                                    Add Player <i class="bi bi-plus-lg ms-2"></i>
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
