@extends("layout.layout")

@section("content")

    <div class="admin-panel-wrapper">
        <h1>Admin panel</h1>
        <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" id="users-and-cars" class="btn btn-default admin-tabs admin-tab-active" href="#tab1" data-toggle="tab">
                    Users & cars
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="polls-and-answers" class="btn btn-default admin-tabs" href="#tab2" data-toggle="tab">
                    Polls & answers
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" id="brands-and-models" class="btn btn-default admin-tabs" href="#tab3" data-toggle="tab">
                    Brands & models
                </button>
            </div>
        </div>

        <div class="well">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1">
                    <h2>Users</h2>
                    <div class="users-wrapper">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Update</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @isset($users)
                                @php($counter = 1)
                                @foreach($users as $user)
                                    <tr class="tablerow {{$user->id}}" data-id="{{$user->id}}">
                                        <th scope="row">{{$counter++}}</th>
                                        <td class="name">{{$user->first_name}}</td>
                                        <td class="last-name">{{$user->last_name}}</td>
                                        <td class="username">{{$user->username}}</td>
                                        <td class="email">{{$user->email}}</td>
                                        <td class="role">{{$user->role}}</td>
                                        <td><button class="btn btn-default btnChangeUser" data-target="#adminUpdateUser" data-toggle="modal">Change</button></td>
                                        <td><button class="btn btn-default btnDeleteUser">Delete</button></td>
                                    </tr>
                                @endforeach
                            @endisset
                            </tbody>
                        </table>
                    </div>
                    <h2>Cars</h2>
                    <div class="cars-wrapper">
                        @isset($cars)
                            @foreach($cars as $car)
                                <div class="single-car {{$car->id}}">
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
                                                                Price:
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info-row price">
                                                                {{$car->price}} &euro;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div class="info-row desc">
                                                    <i>{{$car->description}}</i>
                                                </div>
                                            </div>
                                            <div class="car-actions">
                                                <a href="#" class="btnUpdateCar" data-target="#adminUpdateCar" data-toggle="modal" data-car-id="{{$car->id}}">Update info</a>
                                                <a href="#" class="btnDeleteCar" data-car-id="{{$car->id}}">Delete car</a>
                                                <h4 class="btnConfirmDelete hideDates">Are you sure?</h4>
                                                <a href="#" class="btnConfirmDelete hideDates" data-car-id="{{$car->id}}">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endisset
                    </div>
                    <div class="links-wrapper">
                        @isset($cars)
                            @for($i=0; $i < ceil($cars[0]->num/2); $i++)
                                <span class="link"><a href="#" class="paginate-link {{$i == 0 ? "paginate-link-active" : ""}}" data-page="{{$i+1}}">{{$i+1}}</a></span>
                            @endfor
                        @endisset
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab2">
                    <h2>Polls</h2>
                    <div class="polls-answers-wrapper">
                        <div class="poll-wrapper">
                            <div class="poll-link-wrapper">
                                <a href="#" class="btnAddNewPoll">Add new poll</a>
                                <input type="text" class="tbNewPoll form-control hide-elem" placeholder="New poll">
                                <span class="polls-errors format-errors add hide-elem"></span>
                                <span class="polls-success add hide-elem"></span>
                                <a href="#" class="btnDeletePoll">Delete poll</a>
                                <a href="#" class="btnConfirmDeletePoll hide-elem">Delete selected rows</a>
                                <span class="polls-errors delete format-errors hide-elem"></span>
                                <p class="selected-polls format-errors hide-elem"><b></b></p>
                            </div>
                            <div class="poll-list-wrapper">
                                @isset($polls)
                                    <select name="ddlPolls" id="ddlPolls" class="form-control">
                                        <option value="0">Choose...</option>
                                        @foreach($polls as $poll)
                                            <option value="{{$poll->id}}">{{$poll->question}}</option>
                                        @endforeach
                                    </select>
                                @endisset
                            </div>
                        </div>
                        <div class="answers-wrapper">
                            <div class="answer-list-wrapper">
                                <h3>Choose question to get answers</h3>

                            </div>
                            <div class="answer-links-wrapper hide-elem">
                                <a href="#" class="btnAddNewAnswer">Add new answer</a>
                                <a href="#" class="btnDeleteAnswer">Delete answer</a>
                                <a href="#" class="ConfirmDeleteAnswer hide-elem">Delete selected rows</a>
                                <span class="empty-list-error format-errors  hide-elem"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="tab3">
                    <h2>Car brands</h2>
                    <div class="brands-models-wrapper">
                        <div class="brands-wrapper">
                            <div class="brand-link-wrapper">
                                <a href="#" class="btnAddNewBrand">Add new brand</a>
                                <input type="text" class="tbNewBrand form-control hide-elem" placeholder="New brand">
                                <span class="brands-errors format-errors  add hide-elem"></span>
                                <span class="brands-success add hide-elem"></span>
                                <a href="#" class="btnDeleteBrand">Delete brand</a>
                                <a href="#" class="btnConfirmDelete hide-elem">Delete selected rows</a>
                                <span class="brands-errors format-errors  delete hide-elem"></span>
                                <p class="selected format-errors hide-elem"><b></b></p>
                            </div>
                            <div class="brand-list-wrapper">
                                @isset($brands)
                                    <select name="ddlBrands" id="ddlBrands" class="form-control">
                                        <option value="0">Choose...</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                @endisset
                            </div>
                        </div>
                        <div class="models-wrapper">
                            <div class="model-list-wrapper">
                                <h3>Choose brand to get his models</h3>

                            </div>
                            <div class="model-links-wrapper hide-elem">
                                <a href="#" class="btnAddNewModel">Add new model</a>
                                <a href="#" class="btnDeleteModel">Delete model</a>
                                <a href="#" class="ConfirmDeleteModel hide-elem">Delete selected rows</a>
                                <span class="empty-list-error format-errors  hide-elem"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{--MODALS--}}

    <div class="modal adminUpdateUser" tabindex="-1" id="adminUpdateUser" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update user info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="adminUpdateFirstName">First name:</label>
                            <input type="text" class="form-control" id="adminUpdateFirstName" placeholder="First Name">
                            <span class="firstname error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateLastName">Last name:</label>
                            <input type="text" class="form-control" id="adminUpdateLastName" placeholder="Last Name">
                            <span class="lastname error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateUsername">Username:</label>
                            <input type="text" class="form-control" id="adminUpdateUsername" placeholder="Username">
                            <span class="username error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateEmail">Email</label>
                            <input type="email" class="form-control" id="adminUpdateEmail" placeholder="Email">
                            <span class="email error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateRole">Role:</label>
                            <select name="adminUpdateRole" id="adminUpdateRole" class="form-control">

                            </select>
                            <span class="role error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnUpdateUser" data-id="">Update</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal adminUpdateCar" tabindex="-1" id="adminUpdateCar" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update car info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group">
                            <label for="adminUpdateBrand">Brand:</label>
                            <select id="adminUpdateBrand" class="form-control">

                            </select>
                            <span class="brand error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateModel">Model:</label>
                            <select name="ddlModel" id="adminUpdateModel" class="form-control" disabled>
                                <option value="0">Choose...</option>
                            </select>
                            <input type="text" name="tbModel" class="form-control hideInput tbModel" placeholder="Enter model">
                            <span class="model error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateKm">Km passed:</label>
                            <input type="number" class="form-control" id="adminUpdateKm" >
                            <span class="km error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateYear">Year:</label>
                            <select id="adminUpdateYear" class="form-control">
                                @for($i = 2018; $i > 1899; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <span class="year error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdatePrice">Price:</label>
                            <input type="number" class="form-control" id="adminUpdatePrice">
                            <span class="price error"></span>
                        </div>
                        <div class="form-group">
                            <label for="adminUpdateDesc">Descricpiton:</label>
                            <textarea id="adminUpdateDesc" cols="30" rows="5" class="form-control"></textarea>
                            <span class="desc error"></span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnAdminUpdateCar" data-id="">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection