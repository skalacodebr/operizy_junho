{{ Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate']) }}
<div class="row">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<x-required></x-required>
        <div class="form-icon-user">
            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Role Name'),'required'=>'required']) }}
        </div>

        @error('name')
            <span class="invalid-name" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        @if (!empty($permissions))
            <h6 class="mb-2">{{ __('Assign Permission to Roles') }} </h6>
            <table class="table  mb-0" id="dataTable-1">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" class="align-middle checkbox_middle form-check-input"
                                name="checkall" id="checkall">
                        </th>
                        <th>{{ __('Module') }} </th>
                        <th>{{ __('Permissions') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @php

                    $modules = [
                        'Dashboard',
                        'Store Analytics',
                        'Orders',
                        'Role',
                        'User',
                        'Pos',
                        'Products',
                        'Store',
                        'Variants',
                        'Product category',
                        'Product Tax',
                        'Ratting',
                        'Product Coupan',
                        'Subscriber',
                        'Shipping',
                        'Custom Page',
                        'Blog',
                        'Customers',
                        'Plans',
                        'Settings',
                        'Themes',
                        'Reset Password',
                        'Change Store',
                        'Testimonial',
                        ];
                        if (Auth::user()->type == 'super admin') {
                            $modules[] = 'Language';
                        }

                    @endphp
                    @foreach ($modules as $module)
                        <tr>
                            <td><input type="checkbox" class="align-middle ischeck form-check-input"
                                name="checkall" data-id="{{ str_replace(' ', '', $module) }}"></td>
                            <td><label class="ischeck form-label"
                                    data-id="{{ str_replace(' ', '', $module) }}">{{ ucfirst($module) }}</label>
                            </td>
                            <td>
                                <div class="row">
                                    @if (in_array('Manage ' . $module, (array) $permissions))
                                        @if ($key = array_search('Manage ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Manage', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array('Create ' . $module, (array) $permissions))
                                        @if ($key = array_search('Create ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Create', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array('Edit ' . $module, (array) $permissions))
                                        @if ($key = array_search('Edit ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Edit', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array('Delete ' . $module, (array) $permissions))
                                        @if ($key = array_search('Delete ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Delete', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array('Show ' . $module, (array) $permissions))
                                        @if ($key = array_search('Show ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Show', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array('Upgrade ' . $module, (array) $permissions))
                                        @if ($key = array_search('Upgrade ' . $module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Upgrade', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif
                                    @if (in_array($module, (array) $permissions))
                                        @if ($key = array_search($module, $permissions))
                                            <div class="col-md-3 custom-control custom-checkbox">
                                                {{ Form::checkbox('permissions[]', $key, $role->permission, ['class' => 'form-check-input isscheck isscheck_' . str_replace(' ', '', $module), 'id' => 'permission' . $key]) }}
                                                {{ Form::label('permission' . $key, 'Reset Password', ['class' => 'form-label font-weight-500']) }}<br>
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="form-group col-12 py-0 mb-0 d-flex justify-content-end form-label">
        <button type="button" class="btn  btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary ms-2">
    </div>
</div>
{{ Form::close() }}


<script>
    $(document).ready(function () {
        // Global check all
        $('#checkall').on('change', function () {
            var isChecked = $(this).prop('checked');
            $('.ischeck').prop('checked', isChecked);
            $('.isscheck').prop('checked', isChecked);
        });

        // Module row check
        $('.ischeck').on('change', function () {
            let module = $(this).data('id');
            let isChecked = $(this).prop('checked');
            $('.isscheck_' + module).prop('checked', isChecked);
        });

        // Individual permission check
        $('.isscheck').on('change', function () {
            let classes = $(this).attr('class').split(' ');
            let moduleClass = classes.find(c => c.startsWith('isscheck_'));
            if (moduleClass) {
                let module = moduleClass.replace('isscheck_', '');
                let totalPermissions = $('.' + moduleClass).length;
                let checkedPermissions = $('.' + moduleClass + ':checked').length;
                // If all permissions are checked, check the module checkbox, otherwise uncheck it
                $('input[data-id="' + module + '"]').prop('checked', totalPermissions === checkedPermissions);
            }

            // If all modules are checked, check global checkall
            let totalModules = $('.ischeck').length;
            let checkedModules = $('.ischeck:checked').length;
            $('#checkall').prop('checked', totalModules === checkedModules);
        });
    });
</script>
