@extends('layouts.admin.default')
@section('title', 'Icon Categories')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                     Icon Categories
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_icon_category">Add New<i class="bi bi-plus-lg ms-2"></i></button>

                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.icon-category.table.all />
                </div>
                <!------ modals-------------------->
                <livewire:admin.icon-category.modal.create />
                <livewire:admin.icon-category.modal.update />
                <livewire:admin.icon-category.modal.delete />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
