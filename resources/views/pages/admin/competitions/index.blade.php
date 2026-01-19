@extends('layouts.admin.default')
@section('title', 'Competitions')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Competitions
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_competition">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_competitions">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.competitions.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
{{--                    <livewire:admin.competition.table.all />--}}
                    <livewire:admin.competition.table.all-data />
                </div>
                <!------ modals-------------------->
                <livewire:admin.competition.modal.create />
                <livewire:admin.competition.modal.activate />
                <livewire:admin.competition.modal.delete />
                <livewire:admin.competition.modal.import />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
