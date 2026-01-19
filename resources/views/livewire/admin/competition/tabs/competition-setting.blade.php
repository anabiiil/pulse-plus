<div>
    <div class="card">

        <div class="card-title text-capitalize">
            <h3>Competition setting</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Competition Budget</label>
                        <input type="number" wire:change="save_competition_setting('budget')" min="0" class="form-control" id="exampleFormControlInput1" placeholder="Competition Budget" wire:model="budget">
                        @error('budget') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-lg-12 my-2">
                    <h3>Competition Weeks setting</h3>
                </div>
                <div class="col-lg-12 d-flex justify-content-center my-1">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-bordered border-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">week</th>
                                        <th scope="col">transfare</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weeks as $week)
                                    <tr>
                                        <th scope="row">
                                            <h6>{{ $week->name }}</h6>
                                        </th>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <div class="form-group">
                                                    <input type="number" wire:change="save_competition_setting('transfare' , '{{ $week->id }}')" min="0" class="form-control" id="exampleFormControlInput1" placeholder="Competition Budget" wire:model="transfare.{{ $week->id }}">
                                                    @error("transfare.$week->id") <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
