<div id="modal-{{ $id }}-prompt" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12"><h3 class="m-t-none m-b">{!! $title !!}</h3>
                        <p>{!! $message !!}<br/></p>
                        <form role="form" action="{{ $action }}" method="{{ $method }}">
                            @yield($id . '_inputs')

                            @if(strtolower($method) == 'post')
                                {{ csrf_field() }}
                            @endif
                            <hr/>
                            <div>
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Yes</strong></button>
                                    <button class="btn btn-sm btn-default m-t-n-xs" type="button" data-dismiss="modal"><strong>Close</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>