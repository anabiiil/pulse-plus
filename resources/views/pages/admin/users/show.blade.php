@extends('layouts.admin.default')
@section('title', 'Users')

@section('content')


<div class="container-fluid">
<livewire:admin.users.pages.show-user :user_id="$user_id">
</div>

@endsection
