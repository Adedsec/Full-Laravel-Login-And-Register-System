@if ($errors->any())
    <ul>
        @foreach($errors->all() as $error)
            <li class="small mb-2 text-danger">{{$error}}</li>
        @endforeach
    </ul>
@endif
