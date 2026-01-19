<div>
    <div class="text-center">
        <a href="#" wire:click.prevent="$dispatch('update_admin',{ id: {{ $row->id }}})"
           class="text-primary px-1"><i class="fa fa-edit text-primary"></i></a>
        <a href="" class="text-danger px-1"
           wire:click.prevent="$dispatch('delete_admin',{ id: {{ $row->id }}})"><i
                class="fa fa-trash text-danger"></i></a>
    </div>
</div>
