

$(document).ready(function () {


    GlobalformData = new FormData();
    GlobalformData.append("transac", "viewCart");
    addToCart(GlobalformData, "viewCart");


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
        price = parseInt($(this).find("h4 b").html().substring(1));
        product_name = $(this).find("h5").html();

        formData = new FormData();
        formData.append("product_id", toAddProduct_id);

        addToCart(formData, "addToCart", toAddProduct_id, product_name, price);


    });

    $("#counter_body").on("click", "#rmitem", function (e) {
        e.stopPropagation();

        product_id = $(this).parent().attr("id");
        console.log(product_id);


        $(this).closest('ol').addClass("removeItem");
        setTimeout(() => {
            $(this).closest('ol').removeClass("removeItem");
            $(this).closest('ol').remove();
        }, 250);


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

                } else {

                }

            }
        });






    });
    $("#refreshCart").click(function (e) {
        e.preventDefault();
        refresCart = new FormData();
        addToCart(refresCart, "viewCart");
    });

    $("#counter_body").on("submit", "#changeqntity", function (e) {
        e.preventDefault();

        formData = new FormData(this)
        old_qntity = $(this).closest("ol").find(".arrow_controll").next().html();

        qntity = $(this).find("input").val();
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



    function addToCart(formData, tr, p_id, product_name, price) {

        formData.append("transac", tr);



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



                    if (tr != "addToCart") {
                        $('#counter_body').html(response);

                        $('#counter_body').children().hide();


                        $('#counter_body').children().each(function (index) {
                            $(this).delay(index * 200).show(0);
                        });
                    } else {
                        let positive = 0;
                        $('#counter_body').children().each(function () {
                            idCatch = $(this).find(".pr").next().attr("id");
                            if (p_id == idCatch) {
                                qntity = parseInt($(this).find(".arrow_controll").next().html());
                                pr = parseInt($(this).find(".pr").html().substring(1));
                                pr = pr / qntity;
                                console.log(pr);

                                $(this).find(".arrow_controll").next().html(qntity + 1);
                                pr = pr * (qntity + 1);

                                $(this).find(".pr").html("₱" + pr);
                                $(this).find("#changeqntity input").val(qntity + 1);
                                positive++
                            }
                        });


                        if (positive < 1) {

                            hs = $('#counter_body > *:nth-child(1)').hasClass("noItem");

                            if (hs) {
                                $('#counter_body').html(`<ol>
                                    <li>
                                        <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                                        <p>1</p>
                                        <p>${product_name}</p>
                                        <p class="pr">₱${price}</p>
                                        <div id="${p_id}" class="edga"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                                    </li>
                                    <li class="qntity">
                                        <div>
                                            <p>Quantity</p>
                                            <form id="changeqntity">
                                                <input type="number" value="1" name="qntity" >
                                            </form>
                                        </div>
                                    </li>
                                </ol>`);
                            } else {


                                $('#counter_body').append(`<ol>
                                <li>
                                    <p class="arrow_controll"><i class="fas fa-arrow-right"></i></p>
                                    <p>1</p>
                                    <p>${product_name}</p>
                                    <p class="pr">₱${price}</p>
                                    <div id="${p_id}" class="edga"><i id="rmitem" class="fas fa-plus" title="Remove Item" style="transform: rotate(45deg);"></i></div>
                                </li>
                                <li class="qntity">
                                    <div>
                                        <p>Quantity</p>
                                        <form id="changeqntity">
                                            <input type="number" value="1" name="qntity" >
                                        </form>
                                    </div>
                                </li>
                            </ol>`);
                            }

                        }

                    }

                    // $('#counter_body').children().each(function (index) {
                    //     if (index + 1) {
                    //         index = index + 1;
                    //     } else {
                    //         index = index;
                    //     }
                    //     if (index > 1) {

                    //         setTimeout(() => {
                    //             $(`#counter_body ol:nth-child(${index})`).show();

                    //         }, 400);
                    //     } else {

                    //         $(`#counter_body ol:nth-child(${index})`).show();
                    //     }


                    // });

                }
            }
        });

    }



});