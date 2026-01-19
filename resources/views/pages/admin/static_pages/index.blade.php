@extends('layouts.admin.default')
@section('title', 'Static Pages')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Static Pages
                    </div>
                    <div class="prism-toggle">
{{--                        <button--}}
{{--                            class="btn btn-primary-light m-1"--}}
{{--                            data-bs-toggle="modal"--}}
{{--                            data-bs-target="#create_static_page">Add New<i class="bi bi-plus-lg ms-2"></i></button>--}}

                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.static-page.table.all />
                </div>
                <!------ modals-------------------->
{{--                <livewire:admin.static-page.modal.create />--}}
                <livewire:admin.static-page.modal.update />
{{--                <livewire:admin.static-page.modal.delete />--}}
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
