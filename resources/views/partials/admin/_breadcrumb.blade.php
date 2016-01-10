@if($has_page_heading)
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ isset($page_heading)? $page_heading : '' }}</h2>
        @if(!empty($breadcrumb))
            <ol class="breadcrumb">
                @foreach($breadcrumb as $crumb)
                    @include('partials.admin._breadcrumb_item', ['crumb' => $crumb])
                @endforeach
            </ol>
        @endif
    </div>
    <div class="col-lg-2">
    </div>
</div>
@endif