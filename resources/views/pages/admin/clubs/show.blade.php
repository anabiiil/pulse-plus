@extends('layouts.admin.default')
@section('title', 'Clubs')

@section('content')

<div class="container-fluid">

    <livewire:admin.club.modal.show :club_id="$club_id" />
</div>
@endsection
