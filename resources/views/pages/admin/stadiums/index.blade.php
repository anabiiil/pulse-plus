@extends('layouts.admin.default')
@section('title', 'Stadiums')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Stadiums
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_stadium">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_stadiums">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.stadiums.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:admin.stadium.table.all />
                    </div>
                </div>

                <livewire:admin.stadium.modal.create />
                <livewire:admin.stadium.modal.update />
                <livewire:admin.stadium.modal.delete />
                <livewire:admin.stadium.modal.import />
            </div>
        </div>
    </div>
@endsection
