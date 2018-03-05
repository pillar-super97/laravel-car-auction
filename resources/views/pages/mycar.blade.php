@extends("layout.layout")

@section("content")

    <div class="cars-wrapper">
        <h2>My cars</h2>
        @isset($cars)
            @foreach($cars as $car)
                <div class="single-car">
                    <div class="img-wrapper">
                        <img src="{{asset('/').$car->photo}}" alt="{{$car->brand}}" class="img-responsive">
                    </div>
                    <div class="info-wrapper-wrapper">
                        <h4><b>{{$car->brand." ".$car->model}}</b></h4>
                        <div class="info-wrapper">
                            <div class="car-info">
                                <table>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Brand:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->brand}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Model:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->model}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Km passed:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->km_passed}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Year of production:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->year}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Owner:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->FirstName." ".$car->LastName}}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="info-row">
                                                Price:
                                            </div>
                                        </td>
                                        <td>
                                            <div class="info-row">
                                                {{$car->price}} &euro;
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="info-row">
                                    <i>{{$car->description}}</i>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="car-actions">
                                <a href="#">Add this car to auction</a>
                                <div class="auction-start-date hideDates">
                                    Start date: <input type="datetime-local" class="form-control"><br>
                                    End date: <input type="datetime-local" class="form-control">
                                </div>
                                <a href="#">Add this car for rent</a>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        @endisset

    </div>

        @if(session('success'))
            <div class="alert alert-success login error" role="alert">
                {{session('success')}}
            </div>
        @endif

        @isset($errors)
            @if($errors->any())
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            @endif
        @endisset


@endsection