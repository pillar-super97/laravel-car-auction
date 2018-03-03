@extends("layout.layout")

@section("content")

    {{--<img id="image_border" src="{{asset('/')}}images/border.png" alt="border">--}}
    <div class="contact-form">
        <h1>Please register</h1>
        <div class="form-group group-coustume">
            <form method="post" action="/register" id="registerForm">
                {{ csrf_field() }}
                <label for="tbFirstName">First name:</label>
                <input type="text" name="tbFirstName" class="form-control name-form tbFirstName" id="tbFirstName" placeholder="First Name">
                <span class="firstname error"></span><br>
                <label for="tbLastName">Last name:</label>
                <input type="text" name="tbLastName" class="form-control name-form tbLastName" id="tbLastName" placeholder="Last Name">
                <span class="lastname error"></span><br>
                <label for="tbUsername">Username:</label>
                <input type="text" name="tbUsername" class="form-control name-form tbUsername" id="tbUsername" placeholder="Username">
                <span class="username error"></span><br>
                <label for="tbPassword">Password:</label>
                <input type="password" name="tbPassword" class="form-control name-form tbPassword" id="tbPassword" placeholder="Password">
                <span class="password error"></span><br>
                <label for="tbRetype">Retype password:</label>
                <input type="password" name="tbRetype" class="form-control name-form tbRetype" id="tbRetype" placeholder="Retype">
                <span class="retype error"></span><br>
                <label for="tbEmail">Email:</label>
                <input type="email" name="tbEmail" class="form-control name-form tbEmail" id="tbEmail" placeholder="Email">
                <span class="email error"></span><br>
                <button type="button" class="btn btn-default btn-block btnRegister">Submit</button>
            </form>
            @if(session('msg'))
                <div class="alert alert-success login error" role="alert">
                    {{session('msg')}}
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