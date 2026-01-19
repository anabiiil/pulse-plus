@php use Carbon\Carbon; @endphp
<div>
    @foreach($weeks as $week)
        <div class="row my-4">
            <div class="col-xs-12">
                <div class="prism-toggle text-end">
                    <a class="btn btn-primary-light m-1" href="{{route('admin.fixtures.create')}}">Add
                        New<i class="bi bi-plus-lg ms-2"></i></a>
                    <button
                        class="btn btn-primary-light m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#import_fixtures">
                        Import
                    </button>
                    <a
                        class="btn btn-primary-light m-1"

                        href="{{ route('admin.fixtures.export') }}">Export</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title text-capitalize">
                            {{ $week->name }}
                        </div>
                        <div class="prism-toggle">
                            <button
                                wire:click.prevent="syncData({{ $week->id }})"
                                class="btn btn-success-light m-1">
                                Sync Data
                            </button>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-lg-12 col-md-12 col-sm-12 p-2">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-bordered">
                                    <thead>
                                    <tr>
                                        {{--                        <th class="text-center" scope="col">Index</th>--}}
                                        <th class="text-center" scope="col">Index</th>
                                        <th class="text-center" scope="col">Home Club</th>
                                        <th class="text-center" scope="col">Result</th>
                                        <th class="text-center" scope="col">Away Club</th>
                                        <th class="text-center" scope="col">Datetime</th>
                                        {{--                            <th class="text-center" scope="col">Image</th>--}}
                                        {{--                            <th class="text-center" scope="col">Name In Match</th>--}}
                                        {{--                            <th class="text-center" scope="col">T-Shirt</th>--}}
                                        {{--                            <th class="text-center" scope="col">Price</th>--}}
                                        {{--                            <th class="text-center" scope="col">Position</th>--}}
                                        {{--                            <th class="text-center" scope="col">CLub</th>--}}
                                        {{--                            <th class="text-center" scope="col">Country</th>--}}
                                        {{--                            <th class="text-center" scope="col">Status</th>--}}
                                        {{--                            <th class="text-center" scope="col">Actions</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($week->fixtures as $fixture)
                                        <tr>
                                            <td class="text-center"> {{ $loop->iteration }}</td>
                                            <th class="text-center" scope="col">{{ $fixture->homeClub?->name }}</th>
                                            <th class="text-center" scope="col"><span class="badge bg-info text-white">{{ $fixture->home_club_result }} - {{ $fixture->away_club_result }}</span></th>
                                            <th class="text-center" scope="col">{{ $fixture->awayClub?->name }}</th>
                                            <th class="text-center" scope="col">{{ Carbon::parse($fixture->match_date_time)->setTimezone('Asia/Riyadh')->format('j F Y g:i A') }}</th>
                                            <th class="text-center" scope="col">
                                                <a href="{{ route('admin.clubs.show', $row->id) }}"
                                                   class="text-primary px-1"><i class="fa fa-eye text-primary"></i></a>
                                            </th>

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

    @endforeach
</div>
