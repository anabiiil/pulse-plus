@extends('layouts.admin.default')
@section('title', 'Countries')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Countries
                    </div>
                    <div class="prism-toggle">

                        <button
                        class="btn btn-primary-light m-1"
                        data-bs-toggle="modal"
                        data-bs-target="#import_country">Import</button>
                    <a
                        class="btn btn-primary-light m-1"

                        href="{{ route('admin.country.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:admin.country.table.all />
                    </div>
                </div>

               <livewire:admin.country.modal.update />
               <livewire:admin.country.modal.delete />
               <livewire:admin.country.modal.activate />
               <livewire:admin.country.modal.import />
               <livewire:admin.country.modal.deactivate />
            </div>
        </div>
    </div>
@endsection
