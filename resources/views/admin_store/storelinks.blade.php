<div class="row">
    <div class="table-responsive">
        <table class="table mb-0" id="store_link">
            <thead>
                <tr>
                    <th>{{ __('Store Name') }}</th>
                    <th width="150px">{{ __('Store Link') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($storesNames as $key => $storesName)
                    <tr>
                        <td>{{ $storesName }}</td>
                        @foreach ($stores as $store)
                            @if ($store->name == $storesName)
                                <td class="text-end">
                                    <input type="text" value="{{ $store['store_url'] }}" id="myInput_{{ $store['slug'] }}" class="form-control d-inline-block theme-link" readonly="">
                                    <button class="btn btn-outline-primary gap-2 d-flex align-iteams-center cp_store_link" type="button" onclick="myStoreFunction('myInput_{{ $store['slug'] }}')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Click to copy Store link') }}">
                                        <i class="far fa-copy"></i>
                                        {{ __('Store Link') }}
                                    </button>
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function myStoreFunction(id) {
        var copyText = document.getElementById(id);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        show_toastr('Success', '{{ __('Link copied') }}', 'success')
    }
</script>