@extends('layouts.admin.default')
@section('title', 'Users')

@section('content')

@push('css')
<style>
    .text-uppercase {
        text-transform: unset !important;
    }

</style>
@endpush

<!-- Start:: row-12 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title text-capitalize">
                    Users
                </div>

            </div>
            <div class="card-body">
                <livewire:admin.users.table.all>
            </div>
        </div>
    </div>
</div> -
<!-- End:: row-12 -->
@endsection
