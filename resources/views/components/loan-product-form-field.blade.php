<div class="form-group">
    <label for="{{ $field }}">{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
    @if($value)
        <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $value) }}" class="form-control" />
    @else
        <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" />
    @endif
</div>
