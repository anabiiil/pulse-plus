<div class="text-center">

    <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="{{route('admin.player.show',$row->id)}}"
           class="text-primary px-1"><i class="fa fa-eye text-primary"></i></a>
        <!--end::Button-->
    </div>
    {{-- <div class="menu-item px-1">
        <!--begin::Button-->
        <a href="{{route('admin.player.edit',$row->id)}}"
            class="text-primary px-1"><i class="fa fa-edit text-primary"></i></a>
        <!--end::Button-->
    </div> --}}
{{--    <div class="menu-item px-1">--}}
{{--        <!--begin::Button-->--}}
{{--        <a href="" class="text-danger px-1"--}}
{{--            wire:click.prevent="$dispatch('delete_player',{ id: {{ $row->id }}})"><i--}}
{{--                class="fa fa-trash text-danger"></i></a>--}}
{{--        <!--end::Button-->--}}
{{--    </div>--}}
</div>
