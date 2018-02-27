@extends("layout.layout")

@section("content")

{{--<img id="image_border" src="{{asset('/')}}images/border.png" alt="border">--}}
<div class="contact-form">
    <h1>Please log in</h1>
    <div class="form-group group-coustume">
        <input type="text" class="form-control name-form" placeholder="Username">
        <input type="password" class="form-control subject-form" placeholder="Password">
        <button type="button" class="btn btn-default btn-block btn-Login">Submit</button>
    </div>
</div>

@endsection