
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr class="text-center">

            @foreach($variantArray as $variant)
                <th><span>{{ ucwords($variant) }}</span></th>
            @endforeach
            <th><span>{{ __('Price') }}</span></th>
            <th><span>{{ __('Quantity') }}</span></th>
            <th><span>{{ __('Action') }}</span></th>
        </tr>
        </thead>
        <tbody>

            @foreach($possibilities as $counter => $possibility)
            <tr>
                @foreach(explode(' : ', $possibility) as $key => $values)
                    <td>
                        <input type="text" autocomplete="off" spellcheck="false" class="form-control wid-100" value="{{ $values }}" name="verians[{{$counter}}][name]" readonly>
                    </td>
                @endforeach
                <td>
                    <input type="number" id="vprice_{{ $counter }}" autocomplete="off" spellcheck="false" placeholder="{{ __('Enter Price') }}" class="form-control wid-100" name="verians[{{$counter}}][price]" required>
                </td>
                <td>
                    <input type="number" id="vquantity_{{ $counter }}" autocomplete="off" spellcheck="false" placeholder="{{ __('Enter Quantity') }}" class="form-control wid-100" name="verians[{{$counter}}][qty]" required>
                </td>
                <td>
                    <a class="align-items-center btn btn-sm btn-icon bg-danger text-white  delete-variant-row" data-bs-placement="top"  data-bs-toggle="tooltip" title="{{ __('delete') }}"><i class="ti ti-trash"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-variant-row', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
