@extends('layouts.admin.default')
@section('title', ' Competition Weeks')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Competition Weeks
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_competition_week">Add New<i class="bi bi-plus-lg ms-2"></i></button>

                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_competition_weeks">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.competition_weeks.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.competition-week.table.all />
                </div>
                <!------ modals-------------------->
                <livewire:admin.competition-week.modal.create />
                <livewire:admin.competition-week.modal.update />
                <livewire:admin.competition-week.modal.delete />
                <livewire:admin.competition-week.modal.import />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
