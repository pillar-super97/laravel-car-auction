@extends("layout.layout")

@section("content")

{{--<img id="image_border" src="{{asset('/')}}images/border.png" alt="border">--}}
<div class="contact-form">
    <h1>Please log in</h1>
    <div class="form-group group-coustume">
        <form method="post" action="/login">
            {{ csrf_field() }}
            <input type="text" name="tbUsername" class="form-control name-form tbUsername" placeholder="Username">
            <input type="password" name="tbPassword" class="form-control subject-form tbPassword" placeholder="Password">
            <button type="submit" class="btn btn-default btn-block btn-Login">Submit</button>
        </form>
    </div>
    @isset($errors)
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
    @endisset
    @if(session('error'))
        {{session('error')}}
    @endif
</div>

@endsection