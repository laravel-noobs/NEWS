<li class="{{ $active ? 'active' : '' }}">
    <a {!! isset($action) ? 'href="' . URL::action($action) . '"' : '' !!}>
        <i class="{{ $icon_class }}"></i>
        <span class="nav-label">{{ $text }}</span>
        @if(isset($items) && count($items) > 0)
        <span class="fa arrow"></span>
        @endif
    </a>
    @if(isset($items) && count($items) > 0)
    <ul class="nav nav-second-level collapse">
        @foreach($items as $item)
        <li class="{{ $item['active'] == true ? 'active' : '' }}">
            <a {!! isset($item['action']) ? 'href="' . URL::action($item['action']) . '"' : '' !!}>{{ $item['text'] }}</a>
        </li>
        @endforeach
    </ul>
    @endif
</li>