{{Form::open(array('route'=>array('stor_rating',[$slug,$id]),'method'=>'post','enctype'=>'multipart/form-data', 'class'=>'needs-validation', 'novalidate'))}}
<div class="profile-popup-item">
    <div class="row form-container">
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'), ['class' => 'form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('title',__('Title'), ['class' => 'form-label']) }}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter Title'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-sm-12 pb-2">
            <div class="form-group">
                {{Form::label('title',__('Rating'), ['class' => 'form-label']) }}
                <div id="rating_div">
                    <div class="rate p-0">
                        <input type="radio" class="rating" id="star5" name="rate" value="5"/>
                        <label for="star5" title="5"></label>
                        <input type="radio" class="rating" id="star4" name="rate" value="4"/>
                        <label for="star4" title="4"></label>
                        <input type="radio" class="rating" id="star3" name="rate" value="3"/>
                        <label for="star3" title="3"></label>
                        <input type="radio" class="rating" id="star2" name="rate" value="2"/>
                        <label for="star2" title="2"></label>
                        <input type="radio" class="rating" id="star1" name="rate" value="1"/>
                        <label for="star1" title="1"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('description',__('Description'), ['class' => 'form-label']) }}
                {{Form::textarea('description',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Description'),'style'=>'font-family: sans-serif;','required'=>'required'))}}
            </div>
        </div>
    </div>
</div>
<div class="form-footer text-right">
    {{-- <button type="button" class="btn-secondary btn" style="margin-left: 15px;" id="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden ="true">{{__('Cancel')}}</span></button> --}}
    <button type="submit" class="btn btn-primary ms-2">{{__('Save Changes')}}</button>
</div>
{{Form::close()}}
<script>
    $(document).on('click','#close',function(){
        $(".fade").removeClass("show");
        $('body').removeClass('modal-open');

    });
</script>
