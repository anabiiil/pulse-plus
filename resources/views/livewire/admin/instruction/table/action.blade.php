<div class="d-flex justify-between align-center">
    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="#" wire:click.prevent="$dispatch('update_instruction',{ id: {{ $row->id }}})"
           class="text-primary px-1"><i class="fa fa-edit text-primary"></i></a>
        <!--end::Button-->
    </div>
    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="" class="text-danger px-1"
           wire:click.prevent="$dispatch('delete_instruction',{ id: {{ $row->id }}})"><i
                class="fa fa-trash text-danger"></i></a>
        <!--end::Button-->
    </div>
    <a href="{{ route('admin.instruction_points.index', $row->id) }}" class="btn-sm btn btn-success">
        Points
    </a>
</div>
