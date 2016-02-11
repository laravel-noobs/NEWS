<div id="modal-{{ $id }}-prompt" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <form role="form" action="{{ $action }}" method="{{ $method }}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{!! $title !!}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p>{!! $message !!}</p>
                            @yield($id . '_inputs')
                            @if(strtolower($method) == 'post')
                                {{ csrf_field() }}
                            @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Đồng ý</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
        </form>
    </div>
</div>