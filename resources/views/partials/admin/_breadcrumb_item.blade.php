@if(empty($crumb['active']))
    <li>
        @if(empty($crumb['url']))
            <span>{{  $crumb['text'] }}</span>
        @else
            <a href="{{ $crumb['url'] }}">{{  $crumb['text'] }}</a>
        @endif
    </li>
@else
    <li class="active">
        <strong>{{  $crumb['text'] }}</strong>
    </li>
@endif