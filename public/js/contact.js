$(document).ready(() => {

    $(document).on('change','#ddlPoll', function () {
        let id = $(this).val();
        let question = $(`#ddlPoll option[value="${id}"]`).text();

        if(id !== '0'){
            $.ajax({
                type: 'post',
                url: '/ajax/getanswers',
                data: {id},
                success(data){
                    if(data.message === 'success'){
                        let html = ``;
                        data.answers.map(answer => {
                            html += `<input type="radio" name="rbBrand" class="rbBrand" value="${answer.id}"> ${answer.answer} <br>`
                        })
                        $('.poll-question h3').text(question)
                        $('.poll-answers').html(html);
                        $('.btnVote').removeClass('hide-elem');
                    }
                },
                error(err){
                    console.log(err)
                }
            })
        }
        else {
            $('.poll-question h3').text('Choose question')
            $('.poll-answers').html('');
            $('.btnVote').addClass('hide-elem');
        }
    })

    $('.btnVote').click(function () {
        let answ = $('input[name="rbBrand"]:checked').val();
        let question = $('#ddlPoll').val();

        $.ajax({
            type: 'post',
            url: '/ajax/vote',
            data:{question, answ},
            success(data){
                if(data.message === 'success'){
                    let html = ``;
                    data.results.map(result => {
                        html += `${result.answer} <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: ${result.res}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>`;
                    })
                    $('.poll-answers').html(html);
                    $(`#ddlPoll option[value="${question}"]`).remove();
                    $('.btnVote').addClass('hide-elem');
                    $('#ddlPoll').val('0');
                    $('.poll-question h3').text('Thank you')
                }
            },
            error(err){
                console.log(err);
            }
        })
    })

    $('.btnAddNewPoll').click( function(e) {
        e.preventDefault();
        if($('.tbNewPoll').hasClass('hide-elem')){
            $('.tbNewPoll').removeClass('hide-elem')
            $(this).text('Cancel');
            $('.btnDeletePoll').addClass('hide-elem')
            $('.tbNewPoll').focus();
        }
        else{
            $('.tbNewPoll').addClass('hide-elem')
            $('.tbNewPoll').val('')
            $(this).text('Add new poll');
            $('.btnDeletePoll').removeClass('hide-elem')
        }
    })

    $('.tbNewPoll').focus( function () {
        let that = this;
        $('.tbNewPoll').off().on('keypress', function (e) {
            if(e.which === 13){
                $(this).trigger('blur');
                const poll = $('.tbNewPoll').val().trim()
                const regPoll = /^[A-Za-z\s\?\.\,]{3,50}$/;
                let error = false;
                if(!regPoll.test(poll)){
                    error = true;
                    $('.polls-errors.add').removeClass('hide-elem').text('Enter valid question');
                }

                if(!error){
                    $('.polls-errors.add').addClass('hide-elem').text('');
                    $.ajax({
                        type:'post',
                        url:'/ajax/insertpoll',
                        data: {poll},
                        success(data){
                            if(data.message === 'success'){
                                let html = `<option value="${data.id}">${poll}</option>`
                                $('#ddlPolls').append(html);
                                $('.polls-success.add').removeClass('hide-elem').text('Successfully inserted');
                                $('.tbNewPoll').val('')
                                setTimeout(() => {
                                    $('.polls-success.add').addClass('hide-elem').text('');
                                }, 1000)
                            }
                        },
                        error(err){
                            console.log(err);
                        }
                    })
                }
            }
        })
    })

    $(document).on('click','.btnDeletePoll',function (e) {
        e.preventDefault();
        if($('.btnAddNewPoll').hasClass('hide-elem')){
            $('.btnAddNewPoll').removeClass('hide-elem')
            $(this).text('Delete poll');
            $('.btnConfirmDeletePoll').addClass('hide-elem')
            $('.polls-errors.delete').addClass('hide-elem').text('')
            $('.selected-polls').addClass('hide-elem')
            let list_arr_poll = [];
            $('ul.poll-list li').each(function () {
                let value = $(this).attr('data-id');
                let name = $(this).text().trim()
                list_arr_poll.push({value, name});
            })
            let html = `<select name="ddlPolls" id="ddlPolls" class="form-control">
                            <option value="0">Choose...</option>`;
            list_arr_poll.map( li => {
                html += `<option value="${li.value}">${li.name}</option>`;
            })
            html += `</select>`;
            $('.poll-list-wrapper').html(html);
        }
        else {
            $('.btnAddNewPoll').addClass('hide-elem')
            $(this).text('Cancel');
            $('.btnConfirmDeletePoll').removeClass('hide-elem')
            $('.selected-polls').removeClass('hide-elem').find('b').text('0 rows selected')
            $('.answer-list-wrapper').html(`<h3>Choose question to get answers</h3>`)
            $('.answer-links-wrapper').addClass('hide-elem');
            let polls_array = [];

            $('#ddlPolls option').each( function(i) {
                if(i > 0){
                    let value = $(this).attr('value');
                    let name = $(this).text().trim();
                    polls_array.push({value, name});
                }
            })

            let html = ` <ul class="list-group poll-list">`;
            polls_array.map( poll => {
                html += `<li class="list-group-item poll" data-id="${poll.value}">${poll.name}</li>`;
            })
            html += `</ul>`;
            $('.poll-list-wrapper').html(html);
        }
    })

    $(document).on('click', 'ul.poll-list li',function () {
        if($(this).hasClass('paginate-link-active')){
            $(this).removeClass('paginate-link-active')
        }
        else {
            $(this).addClass('paginate-link-active')
        }
        $('p.selected-polls b').text(`${$('ul.poll-list').find('.paginate-link-active').length} rows selected`)
    })

    $(document).on('click','.btnConfirmDeletePoll',function (e) {
        e.preventDefault();
        let selected = [];
        let error = false;
        $('ul.poll-list .paginate-link-active').each(function () {
            let id = $(this).attr('data-id');
            selected.push(id);
        })

        if(selected.length === 0){
            $('.polls-errors.delete').removeClass('hide-elem').text('None question are choosen')
            error = true;
        }

        if(!error){
            $('.polls-errors.delete').addClass('hide-elem').text('')
            $.ajax({
                type:'post',
                url:'/ajax/deletePolls',
                data:{selected},
                success(data){
                    if(data === 'success'){
                        $('ul.poll-list .paginate-link-active').each(function () {
                            $(this).remove();
                        })
                        $('p.selected-polls b').text(`0 rows selected`)
                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

    $(document).on('change','#ddlPolls',function () {
        const id = $(this).val();

        if(id !== "0"){
            $.ajax({
                type:'post',
                url:'/ajax/getanswers',
                data:{id},
                success(data){
                    if(data.message === 'success'){
                        if(data.answers.length > 0){
                            let html = `<ul class="list-group answer-list"><div class="main-list-answer">`;
                            data.answers.map(answer => {
                                html += `<li class="list-group-item answer" data-id="${answer.id}">${answer.answer}</li>`;
                            })
                            html += `</div>
                                    <li class="list-group-item new-answer hide-elem">
                                        <input type="text" class="tbNewAnswer form-control" placeholder="New answer">
                                        <span class="answer-errors add hide-elem"></span>
                                    </li>
                                </ul>`;
                            $('.answer-list-wrapper').html(html);
                            $('.answer-links-wrapper').removeClass('hide-elem');
                        }
                        else {
                            let html = `<h3 class="heading">This question doesn't have answers yet</h3>
<ul class="list-group answer-list"><div class="main-list-answer"></div>
                                    <li class="list-group-item new-answer hide-elem">
                                        <input type="text" class="tbNewAnswer form-control" placeholder="New answer">
                                        <span class="answer-errors add hide-elem"></span>
                                    </li>
                                </ul>`;
                            $('.answer-list-wrapper').html(html);
                            $('.answer-links-wrapper').removeClass('hide-elem');
                        }
                    }

                },
                error(err){
                    console.log(err);
                }
            })
        }
        else {
            $('.answer-list-wrapper').html(`<h3>Choose question to get answers</h3>`);
            $('.answer-links-wrapper').addClass('hide-elem');
        }
    })

    $(document).on('click','.btnAddNewAnswer',function (e) {
        e.preventDefault()
        if($('.list-group-item.new-answer').hasClass('hide-elem')){
            $('.list-group-item.new-answer').removeClass('hide-elem')
            $(this).text('Cancel')
            $('.tbNewAnswer').focus();
            $('.btnDeleteAnswer').addClass('hide-elem');
        }
        else{
            $('.list-group-item.new-answer').addClass('hide-elem')
            $(this).text('Add new answer')
            $('.tbNewAnswer').val('');
            $('.btnDeleteAnswer').removeClass('hide-elem');
            $('.answer-errors.add').addClass('hide-elem').text('');
        }
    })

    $(document).on('focus', '.tbNewAnswer', function () {
        let that = this;
        $('.tbNewAnswer').off().on('keypress', function (e) {
            if(e.which === 13){
                $(this).trigger('blur');
                const answer = $('.tbNewAnswer').val().trim()
                const question = $('#ddlPolls').val()
                const regAnswer = /^[A-Za-z\s\?\.\,]{3,50}$/;
                let error = false;
                if(!regAnswer.test(answer)){
                    error = true;
                    $(document).find('.answer-errors.add').removeClass('hide-elem').text('Enter valid answer');
                }

                if(!error){
                    $('.answer-errors.add').addClass('hide-elem').text('');

                    $.ajax({
                        type:'post',
                        url:'/ajax/insertanswer',
                        data: {question, answer},
                        success(data){
                            if(data.message === 'success'){
                                let html = `<li class="list-group-item answer" data-id="${data.id}">${answer}</li>`
                                if($('ul .main-list-answer li').length === 0){
                                    $('h3.heading').remove();
                                }
                                $('ul .main-list-answer').append(html);
                                $('.list-group-item.new-answer').addClass('hide-elem')
                                $('.btnAddNewAnswer').text('Add new answer')
                                $('.tbNewAnswer').val('');
                                $('.btnDeleteAnswer').removeClass('hide-elem');

                            }
                        },
                        error(err){
                            console.log(err);
                        }
                    })
                }
            }
        })
    })

    $(document).on('click','.btnDeleteAnswer',function (e) {
        e.preventDefault();
        if($('ul .main-list-answer li').length > 0){
            $('.empty-list-error').addClass('hide-elem').text('');
            if($('.btnAddNewAnswer').hasClass('hide-elem')){
                $('.btnAddNewAnswer').removeClass('hide-elem')
                $(this).text('Delete answer')
                $('.ConfirmDeleteAnswer').addClass('hide-elem')
                $('ul .main-list-answer li').each(function () {
                    $(this).removeClass('selectable');
                    if($(this).hasClass('paginate-link-active'))
                        $(this).removeClass('paginate-link-active')
                })
            }
            else{
                $('.btnAddNewAnswer').addClass('hide-elem')
                $(this).text('Cancel')
                $('.ConfirmDeleteAnswer').removeClass('hide-elem')
                $('ul .main-list-answer li').each(function () {
                    $(this).addClass('selectable');
                })
            }
        }
        else {
            $('.empty-list-error').removeClass('hide-elem').text('Nothing to delete');
        }
    })

    $(document).on('click', 'ul .main-list-answer li', function () {
        if($(this).hasClass('selectable')){
            if($(this).hasClass('paginate-link-active')){
                $(this).removeClass('paginate-link-active')
            }
            else {
                $(this).addClass('paginate-link-active')
            }
        }
    })

    $(document).on('click', '.ConfirmDeleteAnswer', function (e) {
        e.preventDefault();
        let selected = [];
        let error = false;
        $(document).find('ul .main-list-answer .paginate-link-active').each(function () {
            let id = $(this).attr('data-id');
            selected.push(id);
        })

        if(selected.length === 0){
            error = true;
            $('.empty-list-error').removeClass('hide-elem').text('Choose something');
        }

        if(!error){
            $('.empty-list-error').addClass('hide-elem').text('')
            $.ajax({
                type:'post',
                url:'/ajax/deleteAnswers',
                data:{selected},
                success(data){
                    if(data === 'success'){
                        $('ul .main-list-answer .paginate-link-active').each(function () {
                            $(this).remove();
                        })
                        $('.btnAddNewAnswer').removeClass('hide-elem')
                        $('.btnDeleteAnswer').text('Delete answer')
                        $('.ConfirmDeleteAnswer').addClass('hide-elem')
                        $('ul .main-list-answer li').each(function () {
                            $(this).removeClass('selectable');
                        })
                        if($('ul .main-list-answer li').length === 0){
                            let html = `<h3 class="heading">This question doesn't have answers yet</h3>
<ul class="list-group answer-list"><div class="main-list-answer"></div>
                                    <li class="list-group-item new-answer hide-elem">
                                        <input type="text" class="tbNewAnswer form-control" placeholder="New answer">
                                        <span class="answer-errors add hide-elem"></span>
                                    </li>
                                </ul>`;
                            $('.answer-list-wrapper').html(html);
                        }

                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

})