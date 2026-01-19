@extends('layouts.admin.default')
@section('title', 'Create League')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                      Create League
                    </div>

                </div>
                <div class="card-body">
                  <livewire:admin.league.modal.create/>
                </div>


            </div>
        </div>
    </div>
@endsection
