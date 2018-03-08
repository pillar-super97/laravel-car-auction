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
                                @if(is_null($car->RentStatus))
                                    <div class="auction">
                                        <a href="#" class="btnAddCarToAuction" data-id="{{$car->id}}">Add this car to auction</a>
                                        <div class="car-links hideDates">
                                            <table class="dateTable">
                                                <tr>
                                                    <td>Start date:</td>
                                                    <td><input type="datetime-local" class="form-control rent-date start"></td>
                                                </tr>
                                                <tr>
                                                    <td>End date:</td>
                                                    <td><input type="datetime-local" class="form-control rent-date end"></td>
                                                </tr>
                                                <tr>
                                                    <td>Start price: &euro;</td>
                                                    <td><input type="number" class="form-control start-price"></td>
                                                </tr>
                                                <tr>
                                                    <td>Bid rate: &euro;</td>
                                                    <td><input type="number" class="form-control bid-rate"></td>
                                                </tr>
                                            </table>
                                            <a href="#" class="SubmitToAuction">Submit to auction</a>
                                            <span class="date-errors"></span>
                                        </div>
                                    </div>
                                    <div class="rent">
                                        <a href="#" class="btnAddCarToRent" data-id="{{$car->id}}">Add this car for rent</a>
                                        <div class="car-links hideDates">
                                            <table class="dateTable">
                                                <tr>
                                                    <td>Price per day: &euro;</td>
                                                    <td><input type="number" class="form-control rent-price"></td>
                                                </tr>
                                            </table>
                                            <a href="#" class="SubmitToRent">Submit to rent</a>
                                            <span class="date-errors"></span>
                                        </div>
                                    </div>
                                @elseif(!is_null($car->RentEnd))
                                    <div class="car-status-active {{$car->id}}" data-id="{{$car->id}}">
                                        <h3>This car is currently rented</h3>
                                        <h3>Expire date: <span class="expire-date">{{str_replace("T"," ",$car->RentEnd)}}</span> </h3>
                                        <h3>Time remaining: <span class="time-remaining"></span></h3>
                                    </div>
                                @else
                                    <div class="car-status-pending {{$car->id}}" data-id="{{$car->id}}">
                                        <h3>This car is currently available for rent</h3>
                                        <a href="#" class="btnCancelRent">Cancel</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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