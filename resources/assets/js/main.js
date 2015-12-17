$(document).ready(function()
{
    $('select').selectize();

    $('#amountGivenDiv').hide();

    $('input[name="cash"]').change(function(){
        $('#amountGivenDiv').slideToggle();
        $('#userDiv').slideToggle();
    });
});