<nav class="topnavbar navbar-default topnav">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed toggle-costume" data-toggle="collapse" data-target="#upmenu" aria-expanded="false">
                <span class="sr-only"> Toggle navigaion</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="/"><img src="{{asset('/')}}images/logo1.png" alt="logo"></a>
        </div>
    </div>
    <div class="collapse navbar-collapse" id="upmenu">
        <ul class="nav navbar-nav" id="navbarontop">
            @if(session()->has('links'))
                @foreach(session()->get('links')[0] as $link)
                    @if($link->dropdown == 0 && $link->name != 'Login' && $link->name != 'Logout' && $link->name != 'Register')
                        @if(session()->has('user') && $link->name == 'Admin panel' && session()->get('user')[0]->role == 'admin')
                            <li><a href="{{$link->href}}">{{$link->name}}</a> </li>
                        @endif
                        @if($link->name != 'Admin panel')
                            <li><a href="{{$link->href}}">{{$link->name}}</a> </li>
                        @endif
                    @endif
                @endforeach
                @if(session()->has('user'))
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"	data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My profile<span class="caret"></span></a>
                        <ul class="dropdown-menu dropdowncostume">
                            @foreach(session()->get('links')[0] as $link)
                                @if($link->dropdown == 1)
                                    <li><a href="{{$link->href}}">{{$link->name}}</a> </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</nav>