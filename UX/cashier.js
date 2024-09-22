

$(document).ready(function () {


    $(".products_content > *").each(function(index){
        $(this).css({
             'transition-delay' : s*(1+index) + 's'
        });
    });

    $.ajax({
        url: '../backend/cashier/cashier.products.php',
        method: "POST",
        contentType: false,
        processData: false,
        success: function (response) {
            $('.products_content').html(response);
            $('.products_content').children().hide();


            $('.products_content').children().each(function(index) {
                $(this).delay(index * 200).fadeIn(300); 
            });
        }
    });
    $(".products_content").on("click","ol",function (e) { 
        e.preventDefault();
        product_id = $(this).find("img").attr("id");

        console.log(product_id);
        
    });






});