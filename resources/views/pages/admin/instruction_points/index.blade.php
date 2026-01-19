@extends('layouts.admin.default')
@section('title', 'Instruction Points')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Instruction Points
                    </div>
                    <div class="prism-toggle">
                        <button
                            class="btn btn-primary-light m-1"
                            data-bs-toggle="modal"
                            data-bs-target="#create_instruction_point">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:admin.instruction.tabs.instruction-point.table.all  :instruction_id="$instruction->id"/>
                    </div>
                </div>

                <livewire:admin.instruction.tabs.instruction-point.modal.create :instruction_id="$instruction->id"/>
                <livewire:admin.instruction.tabs.instruction-point.modal.update />
                <livewire:admin.instruction.tabs.instruction-point.modal.delete />
            </div>
        </div>
    </div>
@endsection
