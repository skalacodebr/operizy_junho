@php
    $profile = asset(Storage::url('uploads/profile/'));
@endphp
{{Form::model($userDetail,array('route' => array('customer.profile.update',$slug,$userDetail), 'method' => 'put', 'enctype' => "multipart/form-data"))}}
                    
    <div class="profile-popup-item">
        <div class="form-container profile-item-title ">
            <h3>{{__('Main Information')}}</h3>
        </div>
        <div class="form-container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('Name')}}<sup aria-hidden="true">*</sup></label>
                        {{Form::text('name',null,array('placeholder'=>__('Enter User Name')))}}
                        @error('name')
                            <span class="invalid-name" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4  col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('Email')}}<sup aria-hidden="true">*</sup></label>
                        {{Form::text('email',null,array('placeholder'=>__('Enter User Email')))}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('Avatar')}}</label>
                        <div class="choose-file-wrapper">{{-- upload-btn-wrapper --}}
                            <label for="file-1" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.67952 7.2448C6.69833 7.59772 6.42748 7.89908 6.07456 7.91789C5.59289 7.94357 5.21139 7.97498 4.91327 8.00642C4.51291 8.04864 4.26965 8.29456 4.22921 8.64831C4.17115 9.15619 4.12069 9.92477 4.12069 11.0589C4.12069 12.193 4.17115 12.9616 4.22921 13.4695C4.26972 13.8238 4.51237 14.0691 4.91213 14.1112C5.61223 14.1851 6.76953 14.2586 8.60022 14.2586C10.4309 14.2586 11.5882 14.1851 12.2883 14.1112C12.6881 14.0691 12.9307 13.8238 12.9712 13.4695C13.0293 12.9616 13.0798 12.193 13.0798 11.0589C13.0798 9.92477 13.0293 9.15619 12.9712 8.64831C12.9308 8.29456 12.6875 8.04864 12.2872 8.00642C11.9891 7.97498 11.6076 7.94357 11.1259 7.91789C10.773 7.89908 10.5021 7.59772 10.5209 7.2448C10.5397 6.89187 10.8411 6.62103 11.194 6.63984C11.695 6.66655 12.0987 6.69958 12.4214 6.73361C13.3713 6.8338 14.1291 7.50771 14.2428 8.50295C14.3077 9.07016 14.3596 9.88879 14.3596 11.0589C14.3596 12.229 14.3077 13.0476 14.2428 13.6148C14.1291 14.6095 13.3732 15.2837 12.4227 15.384C11.6667 15.4638 10.4629 15.5384 8.60022 15.5384C6.73752 15.5384 5.5337 15.4638 4.77779 15.384C3.82728 15.2837 3.07133 14.6095 2.95763 13.6148C2.89279 13.0476 2.84082 12.229 2.84082 11.0589C2.84082 9.88879 2.89279 9.07016 2.95763 8.50295C3.0714 7.50771 3.82911 6.8338 4.77903 6.73361C5.10175 6.69958 5.50546 6.66655 6.00642 6.63984C6.35935 6.62103 6.6607 6.89187 6.67952 7.2448Z" fill="white"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.81509 4.79241C6.56518 5.04232 6.16 5.04232 5.91009 4.79241C5.66018 4.5425 5.66018 4.13732 5.91009 3.88741L8.14986 1.64764C8.39977 1.39773 8.80495 1.39773 9.05486 1.64764L11.2946 3.88741C11.5445 4.13732 11.5445 4.5425 11.2946 4.79241C11.0447 5.04232 10.6395 5.04232 10.3896 4.79241L9.24229 3.64508V9.77934C9.24229 10.1328 8.95578 10.4193 8.60236 10.4193C8.24893 10.4193 7.96242 10.1328 7.96242 9.77934L7.96242 3.64508L6.81509 4.79241Z" fill="white"></path>
                                </svg>
                                {{__('Choose file here')}}
                            </label>
                            <input type="file" name="profile" id="file-1" class="file-input">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-popup-item">
        <div class="form-container profile-item-title">
            <h3>{{__('Password Informations')}}</h3>
        </div>
        <div class="form-container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('Current Password')}}</label>
                        {{Form::password('current_password',array('placeholder'=>__('Enter Current Password')))}}
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('New Password')}}</label>
                        {{Form::password('new_password',array('placeholder'=>__('Enter New Password')))}}
                        @error('new_password')
                            <span class="invalid-new_password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="form-group">
                        <label for="">{{__('Re-type New Password')}}</label>
                        {{Form::password('confirm_password',array('placeholder'=>__('Enter Re-type New Password')))}}
                        @error('confirm_password')
                            <span class="invalid-confirm_password" role="alert">
                                <strong class="text-danger">{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-footer text-right">
        {{Form::button(__('Save Changes'),array('type'=>'submit','class'=>'btn'))}}
    </div>
{{Form::close()}}