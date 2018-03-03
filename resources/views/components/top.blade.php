<div class="header">
    <ul class="socialicon">
        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
    </ul>
    <ul class="givusacall">
        <li>Give us a call : +66666666 </li>
    </ul>
    <ul class="logreg">
        @if(session()->has('links'))
            @foreach(session()->get('links')[0] as $link)
                @if(session()->has('user') && $link->name == 'Logout')
                    <li><a href="{{$link->href}}">{{$link->name}}</a></li>
                @else
                    @if(($link->name == 'Login' || $link->name == 'Register') && !session()->has('user'))
                        <li><a href="{{$link->href}}">{{$link->name}}</a></li>
                    @endif
                @endif
            @endforeach
        @endif
    </ul>
</div>