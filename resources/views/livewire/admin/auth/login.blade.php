<div>
    <form wire:submit="login">
        <div class="row gy-3">
            <div class="col-xl-12 mt-0">
                <label for="signin-username" class="form-label text-default">Email</label>
                <input type="email" wire:model="email" class="form-control form-control-lg" id="signin-username" >
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-xl-12 mb-3">
                <label for="signin-password" class="form-label text-default d-block">Password
                </label>
                <div class="input-group">
                    <input type="password" wire:model="password" class="form-control form-control-lg" id="signin-password" placeholder="password">

                    <button class="btn btn-light" type="button" onclick="createpassword('signin-password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                </div>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                <div class="mt-2">
                    <div class="form-check">
                        <input wire:model="remember" class="form-check-input" type="checkbox" value="1" id="defaultCheck1">
                        <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                            Remember me ?
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 d-grid mt-2">
                <button type="submit" class="btn btn-lg btn-primary">Sign In</button>
            </div>
        </div>
    </form>
</div>
