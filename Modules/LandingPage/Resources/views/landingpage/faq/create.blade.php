{{ Form::open(array('route' => 'faq_store', 'method'=>'post', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate')) }}
    <div class="modal-body">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('question', __('Question'), ['class' => 'form-label']) }}<x-required></x-required>
                    {{ Form::text('faq_questions',null, ['class' => 'form-control ', 'placeholder' => __('Enter Question'),'required'=>'required']) }}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('answer', __('Answer'), ['class' => 'form-label']) }}
                    {{ Form::textarea('faq_answer', null, ['class' => 'form-control summernote-simple', 'placeholder' => __('Enter Answer')]) }}
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer pb-0">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-secondary" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
{{ Form::close() }}

