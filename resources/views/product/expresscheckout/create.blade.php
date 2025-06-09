{{ Form::open(['route' => ['expresscheckout.store'], 'method' => 'post', 'class'=>'needs-validation', 'novalidate']) }}
    <div class="row">
        @if ($product->enable_product_variant == 'on')
            @foreach ($product_variant_names as $key => $variant)
                <div class="col-sm-6 mb-4 mb-sm-0">
                    <div class="form-group">
                        <span class="d-block h6 mb-0">
                            <th>
                                <label for="" class="form-label"> {{ ucfirst($variant->variant_name) }}</label><x-required></x-required>
                            </th>
                            <select name="variant_name[]" id='choices-multiple-{{$key}}'  class="form-control variant_name" required>
                                <option value="">{{ __('Select')  }}</option>
                                @foreach ($variant->variant_options as $key => $values)
                                    <option value="{{$values}}">{{$values}}</option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                </div>
            @endforeach
        @endif
        <div class="{{ $product->enable_product_variant == 'on' ? 'col-sm-6 mb-4 mb-sm-0' : 'col-12' }}">
            <div class="form-group">
                {{ Form::label('quantity',__('Quantity'),['class'=>'form-label']) }}<x-required></x-required>
                {{ Form::number('quantity', 1, ['class' => 'form-control', 'min' => 1 ,'placeholder'=>__('Enter product Quantity') , 'required']) }}
            </div>
            <input type="hidden" name="product_id" value="{{ $product->id }}">
        </div>
    </div>
    <div class="row">
        <div class="d-flex py-0 mb-0 justify-content-end">
            <button class="btn btn-primary">{{ __('Generate URL') }}</button>
        </div>
    </div>
{{ Form::close() }}
