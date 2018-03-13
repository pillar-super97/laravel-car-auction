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

})