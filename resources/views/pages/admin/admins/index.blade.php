@extends('layouts.admin.default')
@section('title', 'Admins')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Admins
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_admin">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.admin.table.all-data />
{{--                    <livewire:admin.admin.table.all />--}}
                </div>
                <!------ modals-------------------->
                <livewire:admin.admin.modal.create />
                <livewire:admin.admin.modal.update />
                <livewire:admin.admin.modal.delete />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
