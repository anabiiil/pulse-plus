@extends('layouts.admin.default')
@section('title', 'Fixtures')

@section('content')
    <livewire:admin.fixture.page.all :fixture="$fixture"/>
    <livewire:admin.fixture.modal.import />

{{--    <livewire:admin.fixture.table.all-data />--}}


@endsection
