@extends("layout.layout")

@section("content")

    <div class="cars-wrapper">
        @isset($cars)
            <div class="cars-avb-for-rent">
                <h2>Cars available for rent</h2>
                @foreach($cars as $car)
                    @if($car->RentStatus == "available")
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
                                                    <div class="info-row brand">
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
                                                    <div class="info-row model">
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
                                                    <div class="info-row km">
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
                                                    <div class="info-row year">
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
                                                    <div class="info-row owner">
                                                        {{$car->FirstName." ".$car->LastName}}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="info-row">
                                                        Price per day:
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="info-row price">
                                                        {{$car->price_per_day}} &euro;
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="info-row desc">
                                            <i>{{$car->description}}</i>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="car-actions">
                                        @if($car->RentStatus == "available")
                                            {{--<div class="auction">--}}
                                                {{--<a href="#" class="btnAddCarToAuction" data-id="{{$car->id}}">Add this car to auction</a>--}}
                                                {{--<div class="car-links hideDates">--}}
                                                    {{--<table class="dateTable">--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Start date:</td>--}}
                                                            {{--<td><input type="datetime-local" class="form-control rent-date start"></td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>End date:</td>--}}
                                                            {{--<td><input type="datetime-local" class="form-control rent-date end"></td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Start price: &euro;</td>--}}
                                                            {{--<td><input type="number" class="form-control start-price"></td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Bid rate: &euro;</td>--}}
                                                            {{--<td><input type="number" class="form-control bid-rate"></td>--}}
                                                        {{--</tr>--}}
                                                    {{--</table>--}}
                                                    {{--<a href="#" class="SubmitToAuction">Submit to auction</a>--}}
                                                    {{--<span class="date-errors"></span>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <div class="rent">
                                                <a href="#" class="btnRentCar {{ session()->has('user') ? session()->get('user')[0]->id == $car->user_id ? "disabled":"":"disabled"}}" data-id="{{$car->id}}">{{ session()->has('user') ? session()->get('user')[0]->id == $car->user_id ? "You can't rent own car":"Rent this car":"Please log in to rent"}}</a>
                                                <div class="car-links hideDates">
                                                    <table class="dateTable">
                                                        <tr>
                                                            <td>Until date:</td>
                                                            <td><input type="datetime-local" class="form-control rent-date end"></td>
                                                        </tr>
                                                    </table>
                                                    <a href="#" class="btnConfirmRent">Rent</a>
                                                    <span class="date-errors"></span>
                                                </div>
                                            </div>
                                        @elseif(!is_null($car->RentEnd))
                                            <div class="car-status-active {{$car->id}}" data-id="{{$car->id}}">
                                                <h3>This car is currently rented</h3>
                                                <h3>Expire date: <span class="expire-date">{{str_replace("T"," ",$car->RentEnd)}}</span> </h3>
                                                <h3>Time remaining: <span class="time-remaining"></span></h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="cars-curr-rented">
                <h2>Rented cars</h2>
                @foreach($cars as $car)
                    @if($car->RentStatus == "rented")
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
                                                        Price per day:
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="info-row">
                                                        {{$car->price_per_day}} &euro;
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
                                            <div class="car-status-active {{$car->id}}" data-id="{{$car->id}}">
                                                <h3>This car is currently rented by {{$car->renter}}</h3>
                                                <h3>Expire date: <span class="expire-date">{{str_replace("T"," ",$car->RentEnd)}}</span> </h3>
                                                <h3>Time remaining: <span class="time-remaining"></span></h3>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endisset

    </div>

    @isset($errors)
        @if($errors->any())
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        @endif
    @endisset


@endsection