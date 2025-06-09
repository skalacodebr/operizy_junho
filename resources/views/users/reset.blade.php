{{ Form::model($user, ['route' => ['users.resetpassword', $user->id], 'method' => 'post', 'class'=>'needs-validation', 'novalidate']) }}

    <div class="row">
        <div class="form-group">

            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}<x-required></x-required>
            <div class="form-icon-user">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password" placeholder="Enter Password">
            </div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">

            {{ Form::label('password_confirmation', __('Confirm Password'), ['class' => 'form-label']) }}<x-required></x-required>
            <div class="form-icon-user">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password" placeholder="Enter Confirm Password">
            </div>
        </div>
        <div class="login_field d-none"></div>
    </div>
<div class="d-flex py-0 mb-0 justify-content-end">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary ms-2">
</div>
{{ Form::close() }}
