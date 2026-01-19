@extends('layouts.admin.default')
@section('title', 'Update League')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                      Update League
                    </div>

                </div>
                <div class="card-body">
                  <livewire:admin.league.modal.update :league_id="$league->id"/>
                </div>


            </div>
        </div>
    </div>
@endsection
