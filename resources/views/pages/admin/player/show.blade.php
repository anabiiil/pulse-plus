@extends('layouts.admin.default')
@section('title', 'Player Details')
@section('content')

<livewire:admin.player.modal.show :player_id="$player->id" />

@endsection
