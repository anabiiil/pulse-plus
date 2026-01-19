<div class="d-flex justify-between align-center">

    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="" wire:click.prevent="$dispatch('update_calculate_point',{calculate_point_id : {{ $row->id }}})" class="text-primary px-1"><i class="fa fa-edit text-primary"></i></a>
        <!--end::Button-->
    </div>
    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="" class="text-danger px-1" wire:click.prevent="$dispatch('delete_calculate_point',{ calculate_point_id: {{ $row->id }}})"><i class="fa fa-trash text-danger"></i></a>
        <!--end::Button-->
    </div>


</div>
