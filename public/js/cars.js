$(document).ready( () => {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#ddlBrand').change( function () {
        let brand = $(this).val();
        if(brand != "0" && brand != 'other'){
            $.ajax({
                type: 'POST',
                url: '/getmodel',
                data: {brand},
                success(data){

                    if(data.status == 'has'){
                        let html = '<option value="0">Choose...</option>';
                        data.models.map( model => {
                            html += `<option value="${model.id}">${model.name}</option>`
                        })
                        $('#ddlModel').html(html);
                        $('#ddlModel').prop('disabled', false);

                        if($('.car-model-box #ddlModel').hasClass('hideInput')){
                            $('.car-model-box #ddlModel').removeClass('hideInput')
                            $('.car-model-box .tbModel').addClass('hideInput');
                        }

                        if(!$('.car-brand-box .tbBrand').hasClass('hideInput')){
                            $('.car-brand-box .tbBrand').addClass('hideInput');
                        }

                    }
                    else {
                        if(!$('.car-brand-box .tbBrand').hasClass('hideInput')){
                            $('.car-brand-box .tbBrand').addClass('hideInput');
                        }
                        $('.car-model-box #ddlModel').addClass('hideInput');
                        $('.car-model-box .tbModel').removeClass('hideInput');
                    }
                }
            })
        }
        else if(brand === 'other'){
            $('.car-brand-box .tbBrand').removeClass('hideInput');
            $('.car-model-box #ddlModel').addClass('hideInput');
            $('.car-model-box .tbModel').removeClass('hideInput');
        }
        else {
            $('.car-model-box #ddlModel').removeClass('hideInput');
            $('#ddlModel').prop('disabled', true);
            $('.car-model-box .tbModel').addClass('hideInput');
        }
    })

    $('.btnUploadCar').click( () => {
        let brand = $('#ddlBrand').val()
        if(brand === 'other')
            brand = $('.tbBrand').val();
        let model;
        if($('#ddlModel').hasClass('hideInput')){
            model = $('.tbModel').val()
        }
        else{
            model = $('#ddlModel').val()
        }
        let year = $('#ddlYear').val();
        let km = $('#nbKm').val();
        let price = $('#nbPrice').val();
        let description = $('#taDesription').val();
        let photo = $('#filePhoto').val()
        let extension = photo.split('.').pop();
        let errors = false;

        const regBrand = /^[A-Z][a-z]{3,20}(\s[A-z][a-z]{1,20}){0,3}$/;
        const regModel = /^[A-Za-z0-9]{3,20}(\s[A-za-z0-9]{1,20}){0,2}$/;
        const regNum = /^[0-9]{1,10}$/;
        const regExt = /^(jpe?g|png)$/;

        if(isNaN(brand) || brand === ''){
            if(!regBrand.test(brand)){
                errors = true;
                $('.brand.error').text('Enter valid brand').css('color', 'red');
            }
            else
            {
                $('.brand.error').text('')
            }
        }
        else {
            if(brand == "0"){
                errors = true;
                $('.brand.error').text('Please choose one option').css('color', 'red');
            }
            else {
                $('.brand.error').text('')
            }
        }

        if(isNaN(model) || model === ''){
            if(!regModel.test(model)){
                errors = true;
                $('.model.error').text('Enter valid model').css('color', 'red');
            }
            else{
                $('.model.error').text('');
            }
        }
        else{
            if(model == "0"){
                errors = true;
                $('.model.error').text('Please choose one option').css('color', 'red');
            }
            else {
                $('.model.error').text('');
            }
        }
        if(!regNum.test(price) || price < 0){
            errors = true;
            $('.price.error').text('Enter valid positive number').css('color', 'red');
        }
        else {
            $('.price.error').text('');
        }
        if(!regNum.test(km) || km < 0){
            errors = true;
            $('.km.error').text('Enter valid positive number').css('color', 'red');
        }
        else {
            $('.km.error').text('');
        }
        if(description == ""){
            errors = true;
            $('.description.error').text('Fill out this field!').css('color', 'red');
        }
        else {
            $('.description.error').text('');
        }
        if(!regExt.test(extension)){
            errors = true;
            $('.photo.error').text('File must have jpg, jpeg or png extension').css('color', 'red');
        }
        else {
            $('.photo.error').text('');
        }

        if(!errors){
            if(isNaN(brand)){
                $('#ddlBrand').prop('disabled', true);
            }
            else {
                $('.tbBrand').prop('disabled', true);
            }
            if($('#ddlModel').hasClass('hideInput')){
                $('#ddlModel').prop('disabled', true);
            }
            else{
                $('.tbModel').prop('disabled', true);
            }
            $('#uploadCar').submit();
        }
    })

    $('.btnAddCarToAuction').click( function(e){
        e.preventDefault();
        const root = $(this).parent();
        if(root.find('.car-links').hasClass('hideDates')){
            root.find('.car-links').removeClass('hideDates')
            $(this).text('Cancel')
            root.parent().find('.btnAddCarToRent').addClass('hideDates')
        }
        else{
            root.find('.car-links').addClass('hideDates')
            $(this).text('Add this car to auction')
            root.find('.date-errors').text('')
            root.find('.rent-date.start').val(null);
            root.find('.rent-date.end').val(null);
            root.find('.start-price').val(null)
            root.find('.bid-rate').val(null)
            root.parent().find('.btnAddCarToRent').removeClass('hideDates')
        }
    });

    $(document).on('click','.btnAddCarToRent',function(e){
        e.preventDefault();
        const root = $(this).parent();
        if(root.find('.car-links').hasClass('hideDates')){
            root.find('.car-links').removeClass('hideDates')
            $(this).text('Cancel')
            root.parent().find('.btnAddCarToAuction').addClass('hideDates')
        }
        else{
            root.find('.car-links').addClass('hideDates')
            $(this).text('Add this car to rent')
            root.find('.date-errors').text('')
            root.find('.rent-date.start').val(null);
            root.find('.rent-date.end').val(null);
            root.find('.rent-price').val(null)
            root.parent().find('.btnAddCarToAuction').removeClass('hideDates')
        }
    });

    $(document).on('click','.btnRentCar',function(e){
        e.preventDefault();
        const root = $(this).parent();
        if(root.find('.car-links').hasClass('hideDates')){
            root.find('.car-links').removeClass('hideDates')
            $(this).text('Cancel')
            root.parent().find('.btnAddCarToAuction').addClass('hideDates')
        }
        else{
            root.find('.car-links').addClass('hideDates')
            if($('.cars-avb-for-rent').length)
                $(this).text('Rent this car')
            else
                $(this).text('Add this car to rent')

            root.find('.date-errors').text('')
            root.find('.rent-date.start').val(null);
            root.find('.rent-date.end').val(null);
            root.find('.rent-price').val(null)
            root.parent().find('.btnAddCarToAuction').removeClass('hideDates')
        }
    });

    $('.SubmitToAuction').click( function (e) {
        e.preventDefault();
        const root = $(this).parent().parent()
        const id = root.find('.btnAddCarToAuction').attr('data-id')
        const start = root.find('.rent-date.start').val()
        const end = root.find('.rent-date.end').val()
        const price = root.find('.start-price').val()
        const bid = root.find('.bid-rate').val()
        let errors = false;

        if(start == '' || end == '' || price == '' || price < 1 || bid == '' || bid < 1){
            errors = true;
            root.find('.date-errors').text('Please fill out all fields').css({'color':'red'},{'font-weight':'bold'});
        }
        else{
            root.find('.date-errors').text('');
            if(new Date(start).getTime() < new Date().getTime()){
                errors = true;
                root.find('.date-errors').text('Start date can\'t be in past').css({'color':'red'},{'font-weight':'bold'});
            }
            if(new Date(end).getTime() < new Date(start).getTime() + 86400000){
                errors = true
                root.find('.date-errors').text('Auction must last at least 24 hours').css({'color':'red'},{'font-weight':'bold'});
            }
        }

        if(!errors){
            root.find('.date-errors').text('')
        }

    })

    $(document).on('click','.SubmitToRent', function (e) {
        e.preventDefault();
        const root = $(this).parent().parent();
        const id = root.find('.btnAddCarToRent').attr('data-id');
        const price = root.find('.rent-price').val()
        let errors = false;

        if(price == '' || price < 1){
            errors = true;
            root.find('.date-errors').text('Please insert positive number').css({'color':'red'},{'font-weight':'bold'});
        }

        if(!errors){
            root.find('.date-errors').text('')
            $.ajax({
                type: 'post',
                url: '/ajax/addforrent',
                data: {id, price},
                success(data){
                    if(data === 'success'){
                        let html = `<div class="car-status-pending ${id}" data-id="${id}">
                                        <h3>This car is currently available for rent</h3>
                                        <a href="#" class="btnCancelRent">Cancel</a>
                                    </div>`;
                        root.parent().html(html);
                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

    $(document).on('click','.btnConfirmRent', function (e) {
        e.preventDefault();
        const root = $(this).parent().parent();
        const id = root.find('.btnRentCar').attr('data-id');
        const end = root.find('.rent-date.end').val()
        const parent = root.parent().parent().parent().parent();
        const photo = parent.find('img').attr('src');
        const brand = parent.find('h4 b').text().split(' ')[0];
        const model = parent.find('h4 b').text().split(' ')[1];
        const km = parent.find('.km').text();
        const year = parent.find('.year').text();
        const owner = parent.find('.owner').text();
        const price = parent.find('.price').text();
        const desc = parent.find('.desc').text();
        let errors = false;

        if(end == ''){
            errors = true;
            root.find('.date-errors').text('Please insert valid date').css({'color':'red'},{'font-weight':'bold'});
        }
        else{
            root.find('.date-errors').text('');
            if(new Date(end).getTime() < new Date().getTime()){
                errors = true;
                root.find('.date-errors').text('Until date can\'t be in past').css({'color':'red'},{'font-weight':'bold'});
            }
            else if(new Date(end).getTime() < new Date().getTime() + 86400000) {
                errors = true;
                root.find('.date-errors').text('You can\'t rent a car for less than 24 hours').css({'color':'red'},{'font-weight':'bold'});
            }
        }

        if(!errors){
            root.find('.date-errors').text('')
            $.ajax({
                type: 'post',
                url: '/ajax/rentacar',
                data: {id, end},
                success(data){
                    if(data.message === 'success'){
                        let msg = `<h3><b>Car will be moved into rented section!</b></h3>`;
                        root.parent().parent().html(msg);
                        setTimeout(()=>{
                            parent.remove();
                        },1000);
                        let html = car_templating(id, photo, brand, model, km, year, owner, price, desc, end, 'active', null, 0, data.renter);
                        $('.cars-curr-rented').append(html);
                        timer(end, id);
                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

    $(document).on('click','.btnCancelRent',function (e) {
        e.preventDefault();
        let id = $(this).parent().attr('data-id');
        let root = $(this).parent().parent();
        $.ajax({
            type: 'post',
            url: '/ajax/removerent',
            data: {id},
            success(data){
                let html = `
                <div class="rent">
                    <a href="#" class="btnAddCarToRent" data-id="${id}">Add this car for rent</a>
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
                `
                root.html(html);
            },
            error(err){
                console.log(err);
            }
        })
    })

    if($('.car-status-active').length > 0){
        $('.car-status-active').each(function () {
            let expire = $(this).find('.expire-date').text().trim().replace(" ", "T");
            let id = $(this).attr('data-id');
            timer(expire, id);
        })
    }
})


function timer(exp, id){

    const root = $(`.single-car.${id}`);
    const brand = root.find('.brand').text();
    const model = root.find('.model').text();
    const photo = root.find('img').attr('src');
    const km = root.find('.km').text();
    const year = root.find('.year').text();
    const owner = root.find('.owner').text();
    const desc = root.find('.desc').text();
    const price = root.find('.price').text();

    let expire = new Date(exp).getTime();
    let now = new Date().getTime();
    let diff = expire - now;

    let days = Math.floor(diff / (1000 * 60 * 60 * 24));
    let hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((diff % (1000 * 60)) / 1000);

    if(minutes < 10)
        minutes = "0"+minutes
    if(seconds < 10)
        seconds = "0"+seconds;
    $(`.car-status-active.${id}`).find('.time-remaining').html(`${days}d, ${hours}:${minutes}:${seconds}`);
    let a = setTimeout(function () {
        timer(exp, id);
    }, 1000);
    if(diff < 500){
        clearTimeout(a)
        $.ajax({
            type: 'post',
            url: '/ajax/rentfinished',
            data: {id},
            success(data){
                console.log(data);
                if(data.message === "success"){
                    if($('.cars-avb-for-rent').length){
                        let html = car_templating(id, photo, brand, model, km, year, owner, price, desc, 0, 'available', data.session, data.owner, "");
                        $('.cars-avb-for-rent').append(html);
                        root.remove();
                    }

                    if($(`.car-actions.my-car.${id}`).length){
                        let mycar_html = `<div class="car-status-pending ${id}" data-id="${id}">
                                        <h3>This car is currently available for rent</h3>
                                        <a href="#" class="btnCancelRent">Cancel</a>
                                    </div>`;
                        $(`.car-actions.my-car.${id}`).html(mycar_html);
                    }

                }
            },
            error(err){
                console.log(err);
            }
        })
    }
}

function car_templating(id, img , brand, model, km, year, owner, price, desc, end, status, session, owner_id, renter) {
    let html = `<div class="single-car ${id}">
                            <div class="img-wrapper">
                                <img src="${img}" alt="${brand}" class="img-responsive">
                            </div>
                            <div class="info-wrapper-wrapper">
                                <h4><b>${brand} ${model}</b></h4>
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
                                                        ${brand}
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
                                                        ${model}
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
                                                        ${km}
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
                                                        ${year}
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
                                                        ${owner}
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
                                                        ${price}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="info-row desc">
                                            <i>${desc}</i>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="car-actions">
                                        ${car_status(status, id, end, session, owner_id, renter)}
                                    </div>
                                </div>
                            </div>
                        </div>`;
    return html;
}

function car_status(status, id, end, session, owner, renter) {
    let html;
    if(status === 'active'){
        html = `<div class="car-status-active ${id}" data-id="${id}">
                    <h3>This car is currently rented by ${renter}</h3>
                    <h3>Expire date: <span class="expire-date">${end.replace('T',' ')}</span> </h3>
                    <h3>Time remaining: <span class="time-remaining"></span></h3>
                </div>`
    }
    else{
        let msg = '';
        let disabled = '';
        if(session === null){
            msg = "Please log in to rent";
            disabled = "disabled";
        }
        else{
            if(session !== owner){
                msg = "Rent this car";
            }
            else{
                msg = "You can\'t rent own car";
                disabled = "disabled";
            }
        }

        html = `<div class="rent">
                    <a href="#" class="btnRentCar ${disabled}" data-id="${id}">${msg}</a>
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
                </div>`
    }
    return html;
}