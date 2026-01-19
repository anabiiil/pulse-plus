@extends('layouts.admin.default')
@section('title', 'Seasons')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Seasons
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_season">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_seasons">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.seasons.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.season.table.all />
                </div>
                <!------ modals-------------------->
                <livewire:admin.season.modal.create />
                <livewire:admin.season.modal.update />
                <livewire:admin.season.modal.delete />
                <livewire:admin.season.modal.import />
                <livewire:admin.season.modal.activate />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
