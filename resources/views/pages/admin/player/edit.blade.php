@extends('layouts.admin.default')
@section('title', 'Update Player')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Update Player
                    </div>

                </div>
                <div class="card-body">
                    <livewire:admin.player.modal.update :player_id="$player->id"/>
                </div>


            </div>
        </div>
    </div>
@endsection
