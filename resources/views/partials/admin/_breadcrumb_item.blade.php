@if(empty($crumb['active']))
    <li>
        @if(empty($crumb['action']))
            <span>{{  $crumb['text'] }}</span>
        @else
            <a href="{{ URL::action($crumb['action']) }}">{{  $crumb['text'] }}</a>
        @endif
    </li>
@else
    <li class="active">
        <strong>{{  $crumb['text'] }}</strong>
    </li>
@endif