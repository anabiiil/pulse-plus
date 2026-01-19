@extends('layouts.admin.default')
@section('title', 'Leagues')

@section('content')

    <!-- Start:: row-12 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Leagues
                    </div>
                    <div class="prism-toggle">
                        <a class="btn btn-primary-light m-1" href="{{route('admin.leagues.create')}}">Add
                            New<i class="bi bi-plus-lg ms-2"></i></a>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_leagues">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.leagues.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <livewire:admin.league.table.all />
                </div>
                <!------ modals-------------------->
                <livewire:admin.league.modal.delete />
                <livewire:admin.league.modal.import />
                <!------ modals-------------------->
            </div>
        </div>
    </div> -
    <!-- End:: row-12 -->
@endsection
