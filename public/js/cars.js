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

        if(isNaN(brand)){
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

        if(isNaN(model)){
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
            // if(brand === 'other'){
            //     $('#ddlBrand').val(null);
            // }
            // else {
            //     $('.tbBrand').val(null);
            // }
            // if($('#ddlModel').hasClass('hideInput')){
            //     $('#ddlModel').val(null)
            // }
            // else{
            //     $('.tbModel').val(null)
            // }
            $('#uploadCar').submit();
        }
    })

});