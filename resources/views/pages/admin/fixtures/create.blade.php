@extends('layouts.admin.default')
@section('title', 'Create Fixture')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                      Create Fixture
                    </div>

                </div>
                <div class="card-body">
                  <livewire:admin.fixture.modal.create/>
                </div>


            </div>
        </div>
    </div>
@endsection
