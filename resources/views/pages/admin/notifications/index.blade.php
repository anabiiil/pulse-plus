@extends('layouts.admin.default')
@section('title', 'Notifications')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Notifications
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <livewire:admin.notification.modal.send/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
