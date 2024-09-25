

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
        url: '../Views/cashierProducts.php',
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
        console.log(product_id);
        

        $(this).closest('ol').addClass("removeItem");
        setTimeout(() => {
            $(this).closest('ol').remove();
        }, 500);


        formData = new FormData();
        formData.append("product_id", $(this).parent().attr("id"));
        formData.append("transac", "removeToCart");

        console.log(product_id);
        $.ajax({
            url: '../Views/order.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (!response) {
                    $('#counter_body').html(`<div class="noItem">Cart is empty...</div>`);

                }else{

                    $('#counter_body').html(response);
                }

            }
        });






    });
    $("#refreshCart").click(function (e) {
        e.preventDefault();
        refresCart = new FormData();
        refresCart.append("transac", "viewCart");
        addToCart(refresCart);
    });

    $("#counter_body").on("submit", "#changeqntity", function (e) {
        e.preventDefault();

        formData = new FormData(this)
        old_qntity = $(this).closest("ol").find(".arrow_controll").next().html();

        qntity  = $(this).find("input").val();
        qntity = parseInt(qntity);
        test = $(this).closest("ol").find(".arrow_controll").next().html();

        if (qntity != "" && qntity <= 1000 && qntity != 0) {
            if (qntity != test) {
                // console.log("sent");

                price = $(this).closest("ol").find(".pr").html();
                price = parseInt(price.substring(1));
                price = price / old_qntity;
                price = price * qntity;
                $(this).closest("ol").find(".pr").html("₱" + price);


                product_id = $(this).closest("ol").find(".edga").attr("id");
                $(this).closest("ol").find(".arrow_controll").next().html(qntity);

                console.log(qntity);
                console.log(price);
                

                formData.append("transac", "changeqntity");
                formData.append("product_id", product_id);


                $.ajax({
                    url: '../Views/order.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {

                    }
                });
            } else {
                // console.log("not sent");

            }

        } else {
            $(this).find("input").val($(this).closest("ol").find(".arrow_controll").next().html());
        }

    });



    function addToCart(formData) {




        $.ajax({
            url: '../Views/order.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()

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