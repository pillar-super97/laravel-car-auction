@extends("layout.layout")

    @section("slider")
        @include("components.slider")
    @endsection

@section("content")

<div class="allcontain">
    <div class="feturedsection">
        <h1 class="text-center"><span class="bdots">&bullet;</span>F E A T U R E S<span class="carstxt">C A R S</span>&bullet;</h1>
    </div>
    <div class="feturedimage">
        <div class="row firstrow">

        </div>
    </div>
    <br>
    <br>
    <!-- ________________________Latest Cars Image Thumbnail________________-->
    <div class="grid">
        <div class="row">
            @isset($gallery)
                @foreach($gallery as $photo)
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="txthover">
                            <img src="{{asset('/')}}{{$photo->path}}" alt="car1">
                            <div class="txtcontent">
                                <div class="stars">
                                    <div class="glyphicon glyphicon-star"></div>
                                    <div class="glyphicon glyphicon-star"></div>
                                    <div class="glyphicon glyphicon-star"></div>
                                </div>
                                <div class="simpletxt">
                                    <h3 class="name">{{$photo->name}}</h3>
                                    <div class="wishtxt">

                                    </div>
                                </div>
                                <div class="stars2">
                                    <div class="glyphicon glyphicon-star"></div>
                                    <div class="glyphicon glyphicon-star"></div>
                                    <div class="glyphicon glyphicon-star"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</div>

@endsection