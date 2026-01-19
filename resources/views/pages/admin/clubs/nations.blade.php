@extends('layouts.admin.default')
@section('title', 'Nations')

@section('content')

<!-- Start:: row-12 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title text-capitalize">
                    Nations
                </div>
                <div class="prism-toggle">
                    <a  class="btn btn-primary-light m-1" data-bs-toggle="modal" data-bs-target="#create_club"  wire:click.prevent="$dispatch(create_nation_club, {club_type:'nation'})">Add New<i class="bi bi-plus-lg ms-2"></i></a>
                    <button class="btn btn-primary-light m-1" data-bs-toggle="modal" data-bs-target="#import_clubs">Import</button>
                    <a class="btn btn-primary-light m-1" href="{{ route('admin.clubs.export') }}">Export</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:admin.club.table.all-nations-club />
            </div>
            <!------ modals-------------------->
            @php
                $club_type = 'nation';
            @endphp
            <livewire:admin.club.modal.create :club_type="$club_type" />
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
