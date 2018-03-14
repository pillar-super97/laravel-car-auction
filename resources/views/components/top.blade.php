<div class="header">
    <ul class="socialicon">
        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a href="https://www.linkedin.com/nhome/?trk=" target="_blank"><i class="fa fa-linkedin"></i></a></li>
        <li><a href="https://github.com/stefan-jevtic" target="_blank"><i class="fa fa-github"></i></a></li>
    </ul>
    <ul class="givusacall">
        <li>Give us a call : +12345687 </li>
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