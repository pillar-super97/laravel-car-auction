@extends("layout.layout")

@section("content")

    {{--<img id="image_border" src="{{asset('/')}}images/border.png" alt="border">--}}
    <div class="contact-form">
        <h1>Please log in</h1>
        <div class="form-group group-coustume">
            <form method="post" action="/register">
                {{ csrf_field() }}
                <label for="tbFirstName">First name:</label>
                <input type="text" name="tbFirstName" class="form-control name-form tbFirstName" id="tbFirstName" placeholder="First Name">
                <label for="tbLastName">Last name:</label>
                <input type="text" name="tbLastName" class="form-control name-form tbLastName" id="tbLastName" placeholder="Last Name">
                <label for="tbUsername">Username:</label>
                <input type="text" name="tbUsername" class="form-control name-form tbUsername" id="tbUsername" placeholder="Username">
                <label for="tbPassword">Password:</label>
                <input type="password" name="tbPassword" class="form-control name-form tbPassword" id="tbPassword" placeholder="Password">
                <label for="tbRetype">Retype password:</label>
                <input type="password" name="tbRetype" class="form-control name-form tbRetype" id="tbRetype" placeholder="Retype">
                <label for="tbEmail">Email:</label>
                <input type="email" name="tbEmail" class="form-control name-form tbEmail" id="tbEmail" placeholder="Email">
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
        @if(session('msg'))
            {{session('msg')}}
        @endif
    </div>

@endsection