<select class="form-control" name="type" id="type" disabled>
    <option value="">Select Type</option>
    @foreach ($staticdata['category_tag_type'] as $kT => $type)
        @if ($kT != 0)
            <option value="{{ $kT }}" 
                {{ $kT === 1 ? 'selected' : '' }}
            >{{ $type }}</option>
        @endif
    @endforeach
</select>