@extends('layouts.admin.default')
@section('title', 'Nations')

@section('content')

<div class="container-fluid">

    <livewire:admin.club.pages.show-country-players :country_id="$country_id" />
</div>
@endsection
