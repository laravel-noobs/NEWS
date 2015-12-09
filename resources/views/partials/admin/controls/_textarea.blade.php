<div class="form-group {{ count($errors->get($name)) > 0 ? 'has-error' : '' }}">
    <label>{{ $caption }}</label>
    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="" class="form-control" {!! $attr or "" !!}>{{ old($name) }}</textarea>
    @if(isset($help))
        <span class="help-block m-b-none">{!! $help !!}</span>
    @endif
    @foreach($errors->get($name) as $err)
        <label class="error" for="{{ $name }}">{{ $err }}</label>
    @endforeach
</div>