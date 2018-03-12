$(document).ready(()=>{
    $(document).on('click', '.admin-tabs', function () {
        $('.admin-tabs').each( function() {
            if($(this).hasClass('admin-tab-active'))
                $(this).removeClass('admin-tab-active');
        })
        $(this).addClass('admin-tab-active');
    })

    $(document).on('click', '.btnChangeUser', function () {
        $('.firstname.error').text('');
        $('.lastname.error').text('');
        $('.username.error').text('');
        $('.email.error').text('');
        $('.role.error').text('');

        const root = $(this).parent().parent();
        const id = root.attr('data-id');
        const name = root.find('.name').text().trim();
        const lastname = root.find('.last-name').text().trim();
        const username = root.find('.username').text().trim();
        const email = root.find('.email').text().trim();
        const role = root.find('.role').text().trim();

        $('#adminUpdateFirstName').val(name);
        $('#adminUpdateLastName').val(lastname);
        $("#adminUpdateUsername").val(username);
        $('#adminUpdateEmail').val(email);
        if(role === 'admin'){
            let html = `<option value="admin">Admin</option><option value="user">User</option>`;
            $('#adminUpdateRole').html(html);
        }
        else{
            let html = `<option value="user">User</option><option value="admin">Admin</option>`;
            $('#adminUpdateRole').html(html);
        }
        $('#btnUpdateUser').attr('data-id', id);
    })

    let usernameAvb = true;

    $('#adminUpdateUsername').blur( () => {
        const username = $('#adminUpdateUsername').val();
        let error = false;
        const id = $('#btnUpdateUser').attr('data-id');
        const oldUsername = $(`.tablerow.${id}`).find('.username').text().trim()
        const regUser = /^[A-z][A-Za-z0-9\_]{3,20}$/;

        if(!regUser.test(username)){
            $('.username.error').text('Username is invalid! Must be at least 4 characters long').css({'color': 'red', 'font-size': '12px'});
            error = true;
            usernameAvb = false;
        }

        if(!error && username !== oldUsername){
            $.ajax({
                type: 'POST',
                url: "/checkUsername",
                data: {username},
                success(data){
                    if(data.message === 'taken'){
                        $('.username.error').text('Username is already taken!').css({'color': 'red', 'font-size': '12px'});
                        usernameAvb = false;
                    }
                    else{
                        $('.username.error').text('Valid username!').css({'color': 'green', 'font-size': '12px'});
                        usernameAvb = true;
                    }
                }
            })
        }

        if(username === oldUsername)
            $('.username.error').text('')
    });

    $('#btnUpdateUser').click( function () {
        const id = $(this).attr('data-id');
        const name = $('#adminUpdateFirstName').val();
        const lastname =  $('#adminUpdateLastName').val();
        const username = $("#adminUpdateUsername").val();
        const email = $('#adminUpdateEmail').val();
        const role = $('#adminUpdateRole').val();

        const regFirstName = /^[A-Z][a-z]{3,20}(\s[A-z][a-z]{1,20}){0,2}$/;
        const regUsername = /^[A-z][A-Za-z0-9\_]{3,20}$/;
        const regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let error = false;

        if(!regFirstName.test(name)){
            $('.firstname.error').text('Name is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.firstname.error').text('')
        }
        if(!regFirstName.test(lastname)){
            $('.lastname.error').text('Last name is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.lastname.error').text('')
        }
        if(!regUsername.test(username) || usernameAvb === false){
            $('.username.error').text('Username is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.username.error').text('')
        }
        if(!regEmail.test(email)){
            $('.email.error').text('Email is invalid').css('color', 'red');
            error = true;
        }
        else {
            $('.email.error').text('')
        }
        if(role !== 'admin' && role !== 'user'){
            $('.role.error').text('Don\'t modify html').css('color', 'red');
            error = true;
        }
        else {
            $('.role.error').text('')
        }

        if(!error && usernameAvb){
            $.ajax({
                type:'post',
                url:'/ajax/updateuser',
                data:{id, name, lastname, username, email, role},
                success(data){
                    if(data === 'success'){
                        const root = $(`.tablerow.${id}`);
                        root.find('.name').text(name);
                        root.find('.lastname').text(lastname);
                        root.find('.username').text(username);
                        root.find('.email').text(email);
                        root.find('.role').text(role);
                        $('#adminUpdateUser').modal('hide');
                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

    $(document).on('click', '.btnDeleteUser', function () {
        const root = $(this).parent().parent();
        const id = root.attr('data-id');

        $.ajax({
            type: 'post',
            url: '/ajax/deleteuser',
            data: {id},
            success(data){
                if(data === 'success'){
                    root.remove();
                }
            },
            error(err){
                console.log(err)
            }
        })
    })

    $(document).on('click','.paginate-link', function (e) {
        e.preventDefault();

        $('.paginate-link').each(function () {
            if($(this).hasClass('paginate-link-active'))
                $(this).removeClass('paginate-link-active')
        })
        $(this).addClass('paginate-link-active');

        let offset = $(this).attr('data-page');

        $.ajax({
            type:'post',
            url:'/ajax/paginate',
            data:{offset},
            success(data){
                if(data.message === 'success'){
                    let html = '';
                    data.cars.map( car => {
                        html += single_car(car.id, car.photo, car.brand, car.model, car.km_passed, car.year, car.price, `${car.FirstName} ${car.LastName}`, car.description)
                    })
                    $('.cars-wrapper').html(html);
                }
            },
            error(err){
                console.log(err);
            }
        })
    })

    $(document).on('click', '.btnUpdateCar', function (e) {
        e.preventDefault();

        const id = $(this).attr('data-car-id');
        const root = $(`.single-car.${id}`);
        const brand = root.find('.brand').text().trim();
        const model = root.find('.model').text().trim();
        const km = root.find('.km').text().trim();
        const year = root.find('.year').text().trim();
        const owner = root.find('.owner').text().trim();
        const desc = root.find('.desc').text().trim();
        const price = root.find('.price').text().trim().replace('€', '').trim();

        $('#adminUpdateKm').val(km);
        $('#adminUpdatePrice').val(price);
        $('#adminUpdateYear').val(year);
        $('#adminUpdateDesc').val(desc)
        $('#btnAdminUpdateCar').attr('data-id',id)
    })

    $('#btnAdminUpdateCar').click(function () {
        let brand = $('#adminUpdateBrand').val()
        let brand_name = $(`#adminUpdateBrand option[value="${brand}"]`).text()
        let model;
        let model_name;
        if($('#adminUpdateModel').hasClass('hideInput')){
            model = $('.tbModel').val()
            model_name = model;
        }
        else{
            model = $('#adminUpdateModel').val()
            model_name = $(`#adminUpdateModel option[value="${model}"]`).text()
        }
        let year = $('#adminUpdateYear').val();
        let km = $('#adminUpdateKm').val();
        let price = $('#adminUpdatePrice').val();
        let description = $('#adminUpdateDesc').val();
        let id = $(this).attr('data-id');
        let errors = false;

        const regBrand = /^[A-Z][a-z]{3,20}(\s[A-z][a-z]{1,20}){0,3}$/;
        const regModel = /^[A-Za-z0-9]{3,20}(\s[A-za-z0-9]{1,20}){0,2}$/;
        const regNum = /^[0-9]{1,10}$/;

        if(brand == "0"){
            errors = true;
            $('.brand.error').text('Please choose one option').css('color', 'red');
        }
        else {
            $('.brand.error').text('')
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
            $('.desc.error').text('Fill out this field!').css('color', 'red');
        }
        else {
            $('.desc.error').text('');
        }

        if(!errors) {
            $.ajax({
                type:'post',
                url: '/ajax/updateCar',
                data: {id, brand, model, year, km, price, description},
                success(data){
                    if(data === 'success'){
                        let root = $(`.single-car.${id}`);
                        root.find('.brand').text(brand_name);
                        root.find('.model').text(model_name);
                        root.find('.km').text(km);
                        root.find('.year').text(year);
                        root.find('.desc').text(description);
                        root.find('.price').text(`${price} €`);
                        root.find('h4 b').text(`${brand_name} ${model_name}`)
                        $('#adminUpdateCar').modal('hide');
                    }
                },
                error(err){
                    console.log(err);
                }
            })
        }
    })

    $('#adminUpdateBrand').change( function () {
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
                        $('#adminUpdateModel').html(html);
                        $('#adminUpdateModel').prop('disabled', false);

                        if($('#adminUpdateModel').hasClass('hideInput')){
                            $('#adminUpdateModel').removeClass('hideInput')
                            $('.tbModel').addClass('hideInput');
                        }

                        if(!$('.tbBrand').hasClass('hideInput')){
                            $('.tbBrand').addClass('hideInput');
                        }

                    }
                    else {
                        if(!$('.tbBrand').hasClass('hideInput')){
                            $('.tbBrand').addClass('hideInput');
                        }
                        $('#adminUpdateModel').addClass('hideInput');
                        $('.tbModel').removeClass('hideInput');
                    }
                }
            })
        }
        else if(brand === 'other'){
            $('.tbBrand').removeClass('hideInput');
            $('#adminUpdateModel').addClass('hideInput');
            $('.tbModel').removeClass('hideInput');
        }
        else {
            $('#adminUpdateModel').removeClass('hideInput');
            $('#adminUpdateModel').prop('disabled', true);
            $('.tbModel').addClass('hideInput');
        }
    })


    $('#adminUpdateCar').on('show.bs.modal', function () {
        $.ajax({
            type:'post',
            url:'/ajax/getbrands',
            success(data){
                if(data.message === 'success'){
                    let html = `<option value="0">Choose...</option>`;
                    data.brands.map(brand => {
                        html += `<option value="${brand.id}">${brand.name}</option>`;
                    })
                    $('#adminUpdateBrand').html(html);
                }
            },
            error(err){
                console.log(err)
            }
        })
    })

    $('#adminUpdateCar').on('hide.bs.modal', function () {
        $('.tbBrand').addClass('hideInput');
        $('#adminUpdateModel').removeClass('hideInput');
        $('#adminUpdateModel').prop('disabled', true);
        $('.tbModel').addClass('hideInput');
        $('.brand.error').text('')
        $('.model.error').text('')
        $('.year.error').text('')
        $('.price.error').text('')
        $('.km.error').text('')
        $('.desc.error').text('')
    })

    $(document).on('click', '.btnDeleteCar', function (e) {
        e.preventDefault();
        if($(this).hasClass('cancel')){
            $(this).removeClass('cancel');
            $(this).text('Delete car')
            $(this).parent().find('.btnConfirmDelete').addClass('hideDates');
            $(this).parent().find('.btnUpdateCar').removeClass('hideDates');
        }
        else {
            $(this).addClass('cancel');
            $(this).text('Cancel')
            $(this).parent().find('.btnConfirmDelete').removeClass('hideDates');
            $(this).parent().find('.btnUpdateCar').addClass('hideDates');
        }
    })

    $(document).on('click', '.btnConfirmDelete', function (e) {
        e.preventDefault();
        const id = $(this).attr('data-car-id')
        $.ajax({
            type:'post',
            url: '/ajax/deleteCar',
            data: {id},
            success(data){
                if(data === 'success'){
                    $(`.single-car.${id}`).remove();
                }
            },
            error(err){
                console.log(err);
            }
        })
    })

})



function single_car(id, img, brand, model, km, year, price, owner, desc) {
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
                                    <div class="car-actions">
                                                <a href="#" class="btnUpdateCar" data-target="#adminUpdateCar" data-toggle="modal" data-car-id="${id}">Update info</a>
                                                <a href="#" class="btnDeleteCar" data-car-id="${id}">Delete car</a>
                                                <h4 class="btnConfirmDelete hideDates">Are you sure?</h4>
                                                <a href="#" class="btnConfirmDelete hideDates" data-car-id="${id}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>`;
    return html;
}