<div class="row">
    <div class="col-lg-12">
        <div class="form-inline pull-right" style="padding-top: 3px">
            <div class="form-group" style="margin-right:5px">
                {!! $products->links() !!}
            </div>
            <div class="form-group" style="margin-right:5px">
                <div class="i-checks">
                    <label>
                        <input type="radio" name="mode" {{ $index_mode == 'list' ? 'checked' : '' }} value="list"> List
                    </label>
                </div>
            </div>
            <div class="form-group" style="margin-right:5px">
                <div class="i-checks">
                    <label>
                        <input type="radio" name="mode" {{ $index_mode == 'grid' ? 'checked' : '' }} value="grid"> Grid
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>

@section('footer-script')
    @parent
    <script>
        $('input[name="mode"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('ProductsController@postConfig') }}',
                method: 'post',
                data: { name: "index.mode", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection