@extends('layouts.admin.default')
@section('title', 'Competition Details')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body p-0">
                {{-- <div class="menu-item px-1">
                    <!--begin::Button-->
                    <button     wire:click.prevent="$dispatch('update_competition',{ id: {{ $competition->id }}})" class="text-primary px-1"><i class="fa fa-edit text-primary"></i></button>
                    <!--end::Button-->
                </div> --}}
                <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                    <div>
                        <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane" type="button" role="tab" aria-controls="info-tab-pane" aria-selected="false"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Settings
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="cash-back-tab" data-bs-toggle="tab" data-bs-target="#cash-back-tab-pane" type="button" role="tab" aria-controls="cash-back-tab-pane" aria-selected="false"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Clubs
                                </button>
                            </li>



                        </ul>
                    </div>
                    <div>

                        <div class="progress progress-xs progress-animate">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%"></div>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab">
                            <livewire:admin.competition.tabs.competition-setting :competition="$competition" />
                        </div>

                        <div class="tab-pane fade" id="cash-back-tab-pane" role="tabpanel" aria-labelledby="cash-back-tab">


                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card custom-card overflow-hidden">
                                        <div class="card-header justify-content-end">


                                            <div class="prism-toggle">
                                                <button class="btn btn-primary-light m-1" data-bs-toggle="modal" data-bs-target="#addClub">Add New<i class="bi bi-plus-lg ms-2"></i></button>
                                            </div>

                                        </div>
                                        <div class="card-body">

                                            <livewire:admin.competition.modal.club :competition="$competition" />

                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <livewire:admin.competition.modal.update />

</div>

@endsection
