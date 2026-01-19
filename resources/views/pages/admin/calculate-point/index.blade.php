@extends('layouts.admin.default')
@section('title', 'Calculate Point')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Calculate Point
                    </div>
                    <div class="prism-toggle">
                        <button class="btn btn-primary-light m-1"  data-bs-toggle="modal" data-bs-target="#create_calculate_point">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.calculate-point.table.all/>
                </div>

                <!------ modals-------------------->
                <livewire:admin.calculate-point.modal.create/>
                <livewire:admin.calculate-point.modal.update/>
                <livewire:admin.calculate-point.modal.delete/>
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
