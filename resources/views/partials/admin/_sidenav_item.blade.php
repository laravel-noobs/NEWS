<li class="{{ $active ? 'active' : '' }}">
    <a href="{{ isset($action) ? action($action) : '#' }}">
        <i class="{{ $icon_class }}"></i>
        <span class="nav-label">{{ $text }}</span>
        @if(isset($items) && count($items) > 0)
        <span class="fa arrow"></span>
        @endif
    </a>
    @if(isset($items) && count($items) > 0)
    <ul class="nav nav-second-level collapse">
        @foreach($items as $item)
        <li class="{{ $item['active'] == true ? 'active' : '' }}"><a href="{{ isset($action) ? action($item['action']) : '#'}}">{{ $item['text'] }}</a></li>
        @endforeach
    </ul>
    @endif
</li>