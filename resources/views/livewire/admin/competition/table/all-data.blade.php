<div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 p-2">
            <div class="table-responsive">
                <table class="table text-nowrap table-bordered">
                    <thead>
                    <tr>
                        <th class="text-center" scope="col">Index</th>
                        <th class="text-center" scope="col">Name</th>
                        <th class="text-center" scope="col">Season</th>
                        <th class="text-center" scope="col">Status</th>
                        <th class="text-center" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all as $element)
                        <tr>
                            <td class="text-center"> {{ $element->index }}</td>
                            <td class="text-center"> {{ $element?->name ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->season?->name ??  "---" }}</td>
                            <td class="text-center"> {{ $element?->status?->value ??  "---" }}</td>
                            <td class="text-center">
                                <livewire:admin.competition.table.action :row="$element" wire:key="{{ $element->id }}"/>
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
