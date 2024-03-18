<div>
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" id="{{ $id ?? '' }}" value="{{ $value ?? '' }}">
</div>
