<div class="d-flex justify-between align-center">
    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="#" wire:click.prevent="$dispatch('update_country',{ id: {{ $row->id }}})"
           class="text-primary px-1"><i class="fa fa-edit text-primary"></i></a>
        <!--end::Button-->
    </div>
    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="" class="text-danger px-1"
           wire:click.prevent="$dispatch('delete_country',{ id: {{ $row->id }}})"><i
                class="fa fa-trash text-danger"></i></a>
        <!--end::Button-->
    </div>

   <div class="menu-item px-3">
     @if($row->status->value == \App\Support\Enums\Main\StatusEnum::INACTIVE->value)
            <a href="#" wire:click.prevent="$dispatch('activate_country',{ id: {{ $row->id }}})" class="menu-link px-3 btn btn-danger btn-sm"
                data-kt-ecommerce-order-filter="enable_row">
                {{  \App\Support\Enums\Main\StatusEnum::INACTIVE->name}}
            </a>
     @else
         <a href="#" wire:click.prevent="$dispatch('deactivate_country',{ id: {{ $row->id }}})" class="menu-link px-3 btn btn-success btn-sm"
            data-kt-ecommerce-order-filter="disable_row">
            {{  \App\Support\Enums\Main\StatusEnum::ACTIVE->name }}
         </a>
     @endif
 </div>
</div>
<!--- doctor name user name -->
