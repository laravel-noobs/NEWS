<?php
    app('navigator')
            ->activate('products', 'reviews')
            ->set_page_heading('Danh sách đánh giá sản phẩm')
            ->set_breadcrumb('admin', 'product_reviews')
            ->set_page_title('Danh sách đánh giá  sản phẩm');
?>

@extends('partials.admin._layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox" style="margin-bottom: 5px">
                <div class="ibox-content" style="padding: 10px 15px 5px 15px">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group search-box">
                                <input placeholder="Tìm đánh giá sản phẩm" id="search-input" type="text" class="form-control input-sm" value="{{ $filter_search_term }}">
                                <span class="input-group-btn">
                                    <button type="button" class="btn-white btn btn-sm"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="post" id="post" class="post form-control">
                                @if($filter_product)
                                    <option value="{{ $filter_product->id }}">{{ $filter_product->name }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-inline" style="padding-top: 3px">
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'notchecked' ? 'checked' : '' }} value="notchecked"> Đợi duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-right:5px">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{  $filter_status_type == 'checked' ? 'checked' : '' }} value="checked"> Đã duyệt
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="i-checks">
                                        <label>
                                            <input type="radio" name="status_type" {{ $filter_status_type == 'all' ? 'checked' : '' }} value="all"> Tất cả
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách đánh giá</h5>

                    <span class="text-muted small pull-right">{{ $reviews->total() }} đánh giá</span>

                </div>
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-page-navigation=".footable-pagination">
                        <thead>
                        <tr>
                            <th data-sort-ignore="true">Người dùng</th>
                            <th data-sort-ignore="true" width="40%">Nội dung</th>
                            <th data-sort-ignore="true" width="20%">Sản phẩm</th>
                            <th data-sort-ignore="true">Ngày nhận</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>
                                    @if($review->user)
                                        <a>{{ $review->user->name }}</a>
                                    @else
                                        <div>{{ $review->name }}</div>
                                        <a href="mailto:{{ $review->email }}" target="_top">{{ $review->email }}</a>
                                    @endif
                                    <div>{{ $review->rate }}</div>
                                    <div>
                                    @if($review->checked)
                                        <i class="fa fa-check-square-o"></i><span> Đã duyệt</span>
                                    @else
                                        <i class="fa fa-square-o"></i><span> Chưa duyệt</span>
                                    @endif
                                    </div>
                                </td>
                                <td>
                                    {{ $review->content }}
                                    <ul class="list-inline action" style="padding-top: 5px; margin-bottom: 0px;">
                                        @if(!$review->checked)
                                            @can('checkProductReview')
                                            <li class=""><a href="{{ URL::action('ProductReviewsController@check', ['id' => $review->id]) }}" class="text-success">Duyệt</a></li>
                                            @endcan
                                        @endif
                                        @can('updateProductReview')
                                            <li class=""><a href="{{ URL::action('ProductReviewsController@edit', ['id' => $review->id]) }}" class="text-success">Sửa</a></li>
                                        @endcan
                                        @can('destroyProductReview')
                                            <li><a data-toggle="modal" href="#modal-product-review-delete-prompt" data-review_title="{{ '#' . $review->id }}" data-review_id="{{ $review->id }}" class="text-danger">Xóa</a></li>
                                        @endcan
                                    </ul>
                                </td>
                                <td><a href="">{{$review->product->name}}</a></td>
                                <td>{{ $review->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <div class="pull-right">{!! $reviews->links() !!}</div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('destroyProductReview')
    @section('product-review-delete_inputs')
        <input name="review_id" type="hidden"/>
    @endsection
    @include('admin.partials._prompt',
        [
            'id' => 'product-review-delete',
            'method' => 'post',
            'action' => URL::action('ProductReviewsController@destroy'),
            'title' => 'Xác nhận',
            'message' => 'Bạn có chắc chắn muốn xóa đánh giá "<span class="review_title">này</span>" hay không?',
        ])
    @endcan

@endsection

@section('footer-script')
    <script>
        $(document).ready(function(){
            $('.footable').footable();
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
        });

        $('input[name="status_type"]').on('ifChecked', function(event){
            $.ajax({
                url: '{{ URL::action('ProductReviewsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.status_type", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });

        $('#modal-product-review-delete-prompt').on('show.bs.modal', function(e) {
            review_id = $(e.relatedTarget).data('review_id');
            review_title = $(e.relatedTarget).data('review_title');
            $(e.currentTarget).find('input[name="review_id"]').val(review_id);
            $(e.currentTarget).find('span.review_title').text(review_title);
        });

        $('.search-box button').on('click', function(){
            box = $(this).parents('.search-box');
            $.ajax({
                url: '{{ URL::action('ProductReviewsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.search_term", value: box.find('#search-input').val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                statusCode: {
                    400: function(jqXHR, textStatus, errorThrown){
                        toastr.error(jqXHR.responseJSON.join('<br/>'));
                    }
                }
            }).done(function() {
                location.reload();
            });
        });

        $("select#post").select2({
            allowClear: true,
            ajax: {
                url: '{{ URL::action('ProductsController@queryProducts') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        query: params.term
                    };
                },
                processResults: function (data, params) {
                    $.map(data, function (data) {
                        data.id = data.id;
                        data.text = data.name;
                    });
                    return {
                        results: data
                    }
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 3,
            templateResult: function (item) {
                if (item.loading) return item.text;
                markup = '<div><span>' + item.text + '</span></div>';
                return markup;
            },
            templateSelection: function (item) {
                if(item.element.dataset.select2Tag == "true")
                    return '<option style="display: inline" value="0" selected="selected">' + item.text + '</option>'; // seem not to work, before submit hack
                else
                    return '<option style="display: inline" value="' + item.id + '" selected="selected">' + item.text + '</option>';
            }
        });
        $("select#post").on("select2:select", function (e) {
            $.ajax({
                url: '{{ URL::action('ProductReviewsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.product", value: $(this).val() },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
        $("select#post").on("select2:unselect", function (e) {
            $.ajax({
                url: '{{ URL::action('ProductReviewsController@postConfig') }}',
                method: 'post',
                data: { name: "filter.product", value: 'NULL' },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function() {
                location.reload();
            });
        });
    </script>
@endsection