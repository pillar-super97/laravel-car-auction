@extends("layout.layout")

@section("content")

    <div class="contact-form">
        <h1>Contact us</h1>
        <div class="form-group group-coustume">
            <form id="loginForm" method="post" action="/login">
                {{ csrf_field() }}
                <input type="text" name="tbEmail" class="form-control name-form tbEmail" placeholder="Email">
                <span class="email error"></span>
                <input type="text" name="tbSubject" class="form-control subject-form tbSubject" placeholder="Subject">
                <span class="subject error"></span>
                <textarea name="" id="" cols="30" rows="5" class="form-control message-form taMessage" placeholder="Message"></textarea>
                <button type="button" class="btn btn-default btn-block btn-Login">Submit</button>
            </form>
        </div>
    </div>
    @if(session()->has('user'))
        <div class="poll-form">
            <h1>Poll</h1>
            <div class="form-group group-coustume">
                <div class="poll-ddl">
                    <select name="ddlPoll" class="form-control" id="ddlPoll">
                        <option value="0">Choose</option>
                        @isset($questions)
                            @foreach($questions as $question)
                                <option value="{{$question->id}}">{{$question->question}}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <div class="poll-question">
                    <h3></h3>
                </div>
                <div class="poll-answers">
                    {{--<div class="progress">--}}
                        {{--<div class="progress-bar" role="progressbar" style="width: 3%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>--}}
                    {{--</div>--}}
                </div>
                <button type="button" class="btn btn-default btn-block btnVote hide-elem">Vote</button>
            </div>
        </div>
    @endif
@endsection