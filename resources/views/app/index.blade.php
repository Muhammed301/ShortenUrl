<x-layout>
    <div class="container-fluid m-5"> 
        <h1 class="font-semibold text-xl text-gray-800 leading-tight text-center">Shorten Your URL</h1>
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
            action="{{ route('url.store') }}"
            class="mt-4 "
        >
                @include('app.form_input')
                <button  type="submit"
                                style="background-color:#2c87c5;color: #fff;
                                padding: 10px 26px;
                                border: 0;
                                border-radius: 3px
                            px
                            ;
                                text-decoration: none">    Save
                             </button>
        </x-form>
            
        </div>

        <table class="table table-striped mt-5"  style="width: 100%; ">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Original Url</th>
                    <th scope="col">Shorten Url</th>
                    <th scope="col">Created at</th>
                </tr>
            </thead>
            @if($urls)
            
            <tbody>
                <tr>
                    
                    @foreach ($urls as $url)
                        <tr style="text-align:center">
                            <td scope="row">{{ $loop->iteration}}</td>
                            <td scope="row">{{ $url->original_url}}</td>
                            <td scope="row">{{ $url->shorten_url}}</td>
                            <td scope="row">{{ $url->created_at}}</td>
                            <td scope="row"><a
                            href="{{ route('edit', $url) }}"
                            class="mr-1"
                        >
                            <button
                                type="button"
                                class="button"
                            >
                                <i
                                    class="icon ion-md-create"
                                ></i>
                            </button>
                        </a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">There are no data.</td>
                    </tr>
                @endif
                    
                </tr>
            </tbody>
            
    
        </table>
    </div>
    
</x-layout>