@php $editing = isset($url) @endphp
<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="original_url"
            label="URL"
            :value="old('original_url', ($editing ? $url->original_url : ''))"
            maxlength="255"
            placeholder="Input you URL here"
            required
        ></x-inputs.text>
        
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="status"
            label="Status"
            
        >
            @php $selected = old('status', ($editing ? $url->statusd : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Status</option>
            @foreach($status as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>


  

 



  
</div>
