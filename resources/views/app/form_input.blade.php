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


  

 



  
</div>