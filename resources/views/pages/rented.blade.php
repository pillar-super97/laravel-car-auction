@extends("layout.layout")

@section("content")

    <div class="cars-wrapper">
        <h2>My rents</h2>
        @isset($cars)
            @foreach($cars as $car)
                <div class="single-car rented">
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
                            <div class="car-actions my-car {{$car->id}}" data-id="{{$car->id}}">
                                @if(!is_null($car->RentEnd))
                                    <div class="car-status-active {{$car->id}}" data-id="{{$car->id}}">
                                        <h3>Expire date: <span class="expire-date">{{str_replace("T"," ",$car->RentEnd)}}</span> </h3>
                                        <h3>Time remaining: <span class="time-remaining"></span></h3>
                                    </div>
                                @endif
                                    <a href="#" class="btnEndRent">Cancel rent</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
        @empty($cars)
            <h2>You haven't rented any cars yet</h2>
        @endempty
    </div>

@endsection