<x-layout>
    <div class="container-fluid m-5"> 
        <h1 class="font-semibold text-xl text-gray-800 leading-tight text-center">Edit URL</h1>
        @if(session('success'))
    <div style="background-color: aquamarine" class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background-color:red " class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div class="input-div">
            <x-form
            method="POST"
            action="{{ route('update', $url) }}"
            class="mt-4 "
        >
                @include('app.form_input')
                <button  type="submit"
                    style="background-color:#2c87c5;color: #fff;
                    padding: 10px 26px;
                    border: 0;
                    border-radius: 3px;
                    text-decoration: none">    Save
                </button>
        </x-form>
            
        </div>


    </div>
    
</x-layout>