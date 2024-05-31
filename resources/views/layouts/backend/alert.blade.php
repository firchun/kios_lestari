@if (Session::has('success'))
    {{-- <div class="alert alert-success alert-dismissible" role="alert">
        {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div> --}}
    <div class="alert alert-gradient mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert"
            aria-label="Close"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" data-dismiss="alert"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="feather feather-x close">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg></button> {{ Session::get('success') }}</div>
@elseif (Session::has('danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        {{ Session::get('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible" role="alert">
        @foreach ($errors->all() as $item)
            <ul>
                <li>{{ $item }}</li>
            </ul>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif
