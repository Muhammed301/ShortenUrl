@php $editing = isset($url) @endphp
<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', )"
            placeholder="Input you URL here"
            required
        ></x-inputs.text>
        
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select
            name="paymentMethod"
            label="Payment Method"
            required
            
        >
            @php $selected = old('status') @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the payment method of your choice </option>
            @foreach($paymentMethod as $value => $label)
            <option value="{{ $label }}" {{ $selected == $label ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
  
</div>
