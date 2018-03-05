@extends("layout.layout")

@section("content")

        <div class="contact-form">
                <h1>Upload car</h1>
                <div class="form-group group-coustume">
                        <form id="uploadCar" method="post" action="/postcar" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <label for="ddlBrand">Brand:</label>
                                <div class="car-brand-box">
                                        <select name="ddlBrand" id="ddlBrand" class="form-control">
                                                <option value="0">Choose...</option>
                                                @isset($brands)
                                                        @foreach($brands as $brand)
                                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                        @endforeach
                                                        <option value="other">Other</option>
                                                @endisset
                                        </select>
                                        <input type="text" name="tbBrand" class="form-control hideInput tbBrand" placeholder="Enter brand">
                                        <span class="brand error"></span>
                                </div>

                                <label for="ddlModel">Model:</label>
                                <div class="car-model-box">
                                        <select name="ddlModel" id="ddlModel" class="form-control" disabled>
                                                <option value="0">Choose...</option>
                                        </select>
                                        <input type="text" name="tbModel" class="form-control hideInput tbModel" placeholder="Enter model">
                                        <span class="model error"></span>
                                </div>
                                <label for="ddlYear">Year</label>
                                <div class="car-year-box">
                                        <select name="ddlYear" id="ddlYear" class="form-control">
                                                @for($i = 2018; $i>1900; $i--)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                        </select>
                                </div>
                                <label for="nbKm">Kilometers passed:</label>
                                <div class="car-km-box">
                                        <input type="number" name="nbKm" id="nbKm" placeholder="Km">
                                        <span class="km error"></span>
                                </div>
                                <label for="nbPrice">Price:</label>
                                <div class="car-price-box">
                                        <input type="number" name="nbPrice" id="nbPrice" placeholder="Price"> &euro;
                                        <span class="price error"></span>
                                </div>
                                <label for="taDescription">Description:</label>
                                <div class="car-price-box">
                                        <textarea name="taDescription" id="taDesription" cols="30" rows="5"
                                                  class="form-control"></textarea>
                                        <span class="description error"></span>
                                </div>
                                <label for="filePhoto">Photo:</label>
                                <div class="car-photo-box">
                                        <input type="file" name="filePhoto" id="filePhoto" class="form-control">
                                        <span class="photo error"></span>
                                </div>

                                <button type="button" class="btn btn-default btn-block btnUploadCar">Upload</button>
                        </form>
                        @if(session('error'))
                                <div class="alert alert-danger login error" role="alert">
                                        {{session('error')}}
                                </div>
                        @endif
                        @if(session('success'))
                                <div class="alert alert-success login error" role="alert">
                                        {{session('success')}}
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