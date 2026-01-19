<div>
    <form wire:submit.prevent="store" class="row" enctype="multipart/form-data">


        <div class="col-xl-6">
            <label for="category-img"
                   class="form-label text-black">Title (English)</label>
            <input type="text" class="form-control" wire:model="title.en">

            @error("title.en") <span
                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
        </div>
        <div class="col-xl-6">
            <label for="category-img"
                   class="form-label text-black">Title (Arabic)</label>
            <input type="text" class="form-control" wire:model="title.ar">

            @error("title.ar") <span
                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
        </div>


        <div class="col-xl-6">
            <label for="category-img"
                   class="form-label text-black">Msg (English)</label>
            <textarea class="form-control" wire:model="msg.en"></textarea>

            @error("msg.en") <span
                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
        </div>


        <div class="col-xl-6">
            <label for="category-img"
                   class="form-label text-black">Msg (Arabic)</label>
            <textarea class="form-control" wire:model="msg.ar"></textarea>

            @error("msg.ar") <span
                class="text-danger d-block mt-2">{{ $message }}</span> @enderror
        </div>


        {{--        @if(!$sendAll)--}}
        <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 mb-2">
            <div id="selectUsersList" @if($sendAll) style="display: none !important;" @endif>
                <label for="selectUsers" class="form-label">Select Users</label>
                <div wire:ignore>
                    <select class="form-control select2" multiple id="selectUsers">
                        <option value="">Select Users</option>
                        @foreach ($users as $user)
                            <option
                                value="{{ $user->id }}" @selected(in_array($user->id,$users_ids))>{{ $user->full_name  ?? $user->team?->name  }} -  ({{  $user->email }}) </option>
                        @endforeach
                    </select>
                </div>

            </div>
            @error('users_ids')
            <span class="text-danger d-block mt-2">{{ $message }}</span>
            @enderror

            @error('users_ids.*')
            <span class="text-danger d-block mt-2">{{ $message }}</span>
            @enderror
        </div>
                @if($sendAll)
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 mb-2">
                        <div class="alert alert-info text-center mt-4">
                            All Users Selected
                        </div>
                    </div>
                @endif


        <div class="col-2">
            <div class="mt-4">
                <label style="visibility: hidden">te</label>
                @if(!$sendAll)
                    or
                    <button type="button" class="btn btn-outline-success" wire:click.prevent="sendAllData">Send All
                        Users
                    </button>
                @else
                    <button type="button" class="btn btn-outline-danger" wire:click.prevent="sendAllData">Reset</button>
                @endif
            </div>


        </div>
        <div class="modal-footer text-center">
            <button type="submit" class="btn btn-success">
                                <span class="indicator-label" wire:loading.class="d-none">
                                    Send
                                </span>
                <span class="d-none" wire:loading.class.remove="d-none">
                                    Wait <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
            </button>


        </div>
    </form>
</div>
@push('js')
    <script>
        $(document).ready(function () {
            $('#selectUsers').change(function () {
                let val = $(this).val();
                @this.
                set('users_ids', val)
            })

        });

    </script>

@endpush
