<form method="post" action="{{ route('coupons.store') }}" class="needs-validation" novalidate>
    @csrf
    @php
        $settings = \App\Models\Utility::settings();
    @endphp
    @if(!empty($settings['chatgpt_key']))
    <div class="d-flex justify-content-end">
        <a href="#" class="btn btn-primary btn-sm" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate',['coupan']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
            <i class="fas fa-robot"></i> {{ __('Generate with AI') }}
        </a>
    </div>
    @endif
    <div class="row">
        <div class="form-group col-md-12">
            {{Form::label('name',__('Name'),array('class'=>'form-label'))}}<x-required></x-required>
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('discount',__('Discount') ,array('class'=>'form-label')) }}<x-required></x-required>
            {{Form::number('discount',null,array('class'=>'form-control','step'=>'0.01','min'=>'0','placeholder'=>__('Enter Discount'),'required'=>'required'))}}
            <span class="small">{{__('Note: Discount in Percentage')}}</span>
        </div>
        <div class="form-group col-md-6">
            {{Form::label('limit',__('Limit') ,array('class'=>'form-label'))}}<x-required></x-required>
            {{Form::number('limit',null,array('class'=>'form-control','min'=>'0','placeholder'=>__('Enter Limit'),'required'=>'required'))}}
        </div>
        <div class="form-group col-md-12" id="auto">
            {{Form::label('limit',__('Code') ,array('class'=>'form-label'))}}<x-required></x-required>
            <div class="input-group">
                {{Form::text('code',null,array('class'=>'form-control','id'=>'auto-code','required'=>'required','placeholder'=>__('Enter Code')))}}
                <button class="btn btn-outline-secondary" type="button" id="code-generate"><i class="fa fa-history pr-1"></i>{{__(' Generate')}}</button>
            </div>
        </div>
        <div class="form-group col-12 d-flex py-0 mb-0  justify-content-end form-label">
            <input type="button" value="{{__('Cancel')}}" class="btn btn-secondary" data-bs-dismiss="modal">
            <input type="submit" value="{{__('Create')}}" class="btn btn-primary ms-2">
        </div>
    </div>
</form>
