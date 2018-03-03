@extends("layout.layout")

@section("content")

<div class="contact-form">
    <h1>Please log in</h1>
    <div class="form-group group-coustume">
        <form id="loginForm" method="post" action="/login">
            {{ csrf_field() }}
            <input type="text" name="tbUsername" class="form-control name-form tbUsername" placeholder="Username">
            <span class="username error"></span>
            <input type="password" name="tbPassword" class="form-control subject-form tbPassword" placeholder="Password">
            <span class="password error"></span>
            <button type="button" class="btn btn-default btn-block btn-Login">Submit</button>
        </form>
        @if(session('error'))
            <div class="alert alert-danger login error" role="alert">
                {{session('error')}}
            </div>
        @endif
    </div>



    @isset($errors)
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
    @endisset

</div>

@endsection