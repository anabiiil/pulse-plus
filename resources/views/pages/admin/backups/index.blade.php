@extends('layouts.admin.default')
@section('title', 'Backups')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">

                <div class="card-header justify-content-between">
                    <div class="card-title text-capitalize">
                        Backups
                    </div>
                    <div class="prism-toggle">
{{--                        <a--}}
{{--                            class="btn btn-primary-light m-1"--}}
{{--                            href="{{ url('admin/create-backup') }}"--}}
{{--                            data-bs-toggle="modal"--}}
{{--                            data-bs-target="#import_country"--}}
{{--                        >Backup Now--}}
{{--                        </a>--}}

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Filename</th>
                                <th>Size</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($backups as $backup)
                                <tr>
                                    <td>{{ $backup['filename'] }}</td>
                                    <td>{{ number_format($backup['size'] / 1024 / 1024, 2) }} MB</td> <!-- Size in MB -->
                                    <td>{{ \Carbon\Carbon::createFromTimestamp($backup['lastModified'])->setTimezone('Asia/Riyadh')->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <a href="{{ route('admin.backups.download', $backup['filename']) }}" class="btn btn-success">
                                            Download
                                        </a>

                                        <a href="{{ route('admin.backups.delete', $backup['filename']) }}" class="btn btn-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No backups available</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

