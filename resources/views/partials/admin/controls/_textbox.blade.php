<div class="form-group {{ count($errors->get($name)) > 0 ? 'has-error' : '' }}">
    <label>{{ $caption }}</label>
    <input type="text" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder or '' }}" value="{{ old($name) }}" class="form-control">
    @if(isset($help))
        <span class="help-block m-b-none">{!! $help !!}</span>
    @endif
    @foreach($errors->get($name) as $err)
        <label class="error" for="{{ $name }}">{{ $err }}</label>
    @endforeach
</div>