@extends('layouts.admin.default')
@section('title', 'Players')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Players
                    </div>
                    <div class="prism-toggle">
                        <a href="{{route('admin.player.create')}}"
                            class="btn btn-primary-light m-1">Add New<i class="bi bi-plus-lg ms-2"></i></a>

                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_players">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.players.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">



                        <livewire:admin.player.table.all-data   />
{{--                        <livewire:admin.player.table.all />--}}
                </div>

                <livewire:admin.player.modal.delete />
                <livewire:admin.player.modal.import />
            </div>
        </div>
    </div>
@endsection
