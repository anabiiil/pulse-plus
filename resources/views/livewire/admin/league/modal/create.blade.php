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
                                                <label for="input-text" class="form-label">English Name</label>
                                                <input type="text" wire:model.live="name.en" name="name.en"
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
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="input-text" class="form-label">Arabic Name</label>
                                                <input type="text" wire:model.live="name.ar" name="name.ar"
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
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="competition_id" class="form-label">Competition</label>
                                                <select wire:model.live="competition_id" class="form-control"
                                                    id="competition_id"  wire:change="filterCompetitionWeeks()">>
                                                    <option value="">select competition</option>
                                                    @foreach ($competitions as $competition)
                                                        <option value="{{ $competition->id }}">{{ $competition->name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('competition_id')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">

                                                <label for="start_week_id" class="form-label">competition week</label>
                                                <select wire:model.live="start_week_id" class="form-control"
                                                    id="start_week_id">
                                                    <option value="">select competition week</option>
                                                    @foreach ($competition_weeks as $competition_week)
                                                        <option value="{{ $competition_week->id }}">
                                                            {{ $competition_week->name }}</option>
                                                    @endforeach

                                                </select>
                                                @error('start_week_id')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="code" class="form-label">Code</label>
                                                <input wire:model.live="code" type="text" class="form-control"
                                                    id="code" placeholder="Code">
                                                @error('code')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="product-discount" class="form-label">Number Of Teams</label>
                                                <input wire:model.live="number_of_teams" min="0" type="number"
                                                    class="form-control" id="product-discount1"
                                                    placeholder="Enter Number Of Teams">
                                                @error('number_of_teams')
                                                    <span class="text-danger d-block mt-2">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                                                <label for="type" class="form-label">Type</label>
                                                <select wire:model.live="type" class="form-control" id="type">
                                                    <option value="">Select</option>
                                                    @foreach ($league_types as $key => $league_type)
                                                        <option value="{{ $key }}">{{ $key }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('type')
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
