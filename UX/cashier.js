

$(document).ready(function () {


    GlobalformData = new FormData();
    GlobalformData.append("transac", "viewCart");
    addToCart(GlobalformData);


    $(".products_content > *").each(function (index) {
        $(this).css({
            'transition-delay': s * (1 + index) + 's'
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


            $('.products_content').children().each(function (index) {
                $(this).delay(index * 200).fadeIn(300);
            });
        }
    });
    $(".products_content").on("click", "ol", function (e) {
        e.preventDefault();
        toAddProduct_id = $(this).find("img").attr("id");

        formData = new FormData();
        formData.append("product_id", toAddProduct_id);
        formData.append("transac", "addToCart");

        addToCart(formData);


    });

    $("#counter_body").on("click", "#rmitem", function (e) {
        e.stopPropagation();

        product_id = $(this).parent().attr("id");

        rmitem = $(this).closest('ol').addClass("removeItem");
        setTimeout(() => {
            $(rmitem).remove();
        }, 100);


        formData = new FormData();
        formData.append("product_id", product_id);
        formData.append("transac", "removeToCart");

        console.log(product_id);
        $.ajax({
            url: '../backend/cashier/order.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (!response) {
                    $('#counter_body').html(`<div class="noItem">Cart is empty...</div>`);

                }
                // $('#counter_body').html(response);

            }
        });






    });
    $("#refreshCart").click(function (e) { 
        e.preventDefault();
        refresCart = new FormData();
        refresCart.append("transac", "viewCart");
        addToCart(refresCart);
    });



    function addToCart(formData) {




        $.ajax({
            url: '../backend/cashier/order.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (!response) {
                    $('#counter_body').html(`<div class="noItem">Cart is empty...</div>`);

                } else {

                    $('#counter_body').html(response);
                    // $('#counter_body').children().hide();



                    // $('#counter_body').children().each(function (index) {
                    //     if (index + 1) {
                    //         index = index + 1;
                    //     } else {
                    //         index = index;
                    //     }
                    //     if (index > 1) {

                    //         setTimeout(() => {
                    //             $(`#counter_body ol:nth-child(${index})`).show();

                    //         }, 200);
                    //     } else {

                    //         $(`#counter_body ol:nth-child(${index})`).show();
                    //     }


                    // });

                }
            }
        });

    }



});