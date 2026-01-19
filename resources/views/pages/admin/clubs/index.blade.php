@extends('layouts.admin.default')
@section('title', 'Clubs')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Clubs
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_club">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_clubs">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.clubs.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
{{--                    <livewire:admin.club.table.all />--}}
                    <livewire:admin.club.table.all-data />
                </div>
                <!------ modals-------------------->
                <livewire:admin.club.modal.create />
                <livewire:admin.club.modal.update />
                <livewire:admin.club.modal.delete />
                <livewire:admin.club.modal.import />
                <livewire:admin.club.modal.update-shirt-image />
                <livewire:admin.club.modal.update-avatar-image />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
