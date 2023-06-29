<div class="col-md-12">
    @if (session()->has('code'))
        <div class="alert alert-sm alert-{{ session()->get('color') }}">
            <small class="text-xs text-white">{{ session()->get('msg') }}</small>
        </div>
    @endif

    @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif
</div>
