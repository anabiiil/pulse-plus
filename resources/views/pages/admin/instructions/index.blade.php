@extends('layouts.admin.default')
@section('title', 'Instructions')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Instructions
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_instruction">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#import_instructions">Import</button>
                        <a
                            class="btn btn-primary-light m-1"

                            href="{{ route('admin.instructions.export') }}">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:admin.instruction.table.all />
                    </div>
                </div>

               <livewire:admin.instruction.modal.create />
               <livewire:admin.instruction.modal.update />
               <livewire:admin.instruction.modal.delete />
               <livewire:admin.instruction.modal.import />
            </div>
        </div>
    </div>
@endsection
