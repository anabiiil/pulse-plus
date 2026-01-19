<div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-2">
            <div class="table-responsive">
                <table class="table text-nowrap table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col">Index</th>
                        <th class="text-center" scope="col">Avatar</th>
                        <th class="text-center" scope="col">T-Shirt</th>
                        <th class="text-center" scope="col">Name</th>
                        <th class="text-center" scope="col">Official name</th>
                        <th class="text-center" scope="col">Code</th>
                        <th class="text-center" scope="col">Stadium</th>
                        <th class="text-center" scope="col">Coach</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all as $element)
                        <tr>
                            <td class="text-center"> {{ $element->index }}</td>
                            <td class="text-center">
                                <a wire:click.prevent="$dispatch('update_club_avatar',{ id: {{ $element->id }} })" href="javascript:void(0)"><img src="{{ $element->fileUrl }}" class="rounded img-fluid img-thumbnail table-img" /></a>
                            </td>

                            <td class="text-center">
                                <a wire:click.prevent="$dispatch('update_club_shirt',{ id: {{ $element->id }} })" href="javascript:void(0)"><img src="{{ $element->tShirtUrl }}" class="rounded img-fluid img-thumbnail table-img" /></a>
                            </td>
                            <td class="text-center"> {{ $element?->name ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->official_name ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->code ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->stadium ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->coach?->name ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->status?->trans() ??  "---" }}</td>
                            <td class="text-center">
                                <livewire:admin.club.table.action :row="$element" wire:key="{{ $element->id }}"/>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>


            </div>
            <div class="mt-4">
                <div class="d-flex justify-content-end">
                    {{ $all->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
