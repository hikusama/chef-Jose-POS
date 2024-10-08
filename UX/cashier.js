

$(document).ready(function () {


    GlobalformData = new FormData();
    GlobalformData.append("transac", "viewCart");
    addToCart(GlobalformData, "viewCart");
    searchNView("", "");
    getCategory()



    $(".products_content > *").each(function (index) {
        $(this).css({
            'transition-delay': s * (1 + index) + 's'
        });
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
            url: '../Views/cashierView.php',
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


    $("#search").on("input", function () {
        category_id = $('.category_nav_inner').find(".prod_nav").attr('id');
        searchNView($(this).val(), category_id);
    });


    $("#removeAllFromCart").click(function (e) {
        e.preventDefault();
        refresCart = new FormData();
        refresCart.append("fakeTransac", "itsaprank")
        removeAllFromCart(refresCart, "viewCart");
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
                    url: '../Views/cashierView.php',
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



    let rotatedimg = false;
    $(".category_nav").on('click', '#allcategory_open', function (e) {
        e.preventDefault();
        if (rotatedimg == false) {
            $("#allcategory_open img").css("transform", "rotate(90deg)")
            $("#allcategory_open img").css("transition", ".3s")
            $(".category_nav_inner").addClass("category_nav_new");
            rotatedimg = true;

        } else {

            $("#allcategory_open img").css("transform", "rotate(0)")
            $(".category_nav_inner").removeClass("category_nav_new");
            rotatedimg = false;
        }
    });


    $(".category_nav_inner").on('click', 'li', function (e) {
        e.preventDefault();
        hasClass = $(this).hasClass("prod_nav");
        catId = $(this).attr("id");
        if (!hasClass) {
            $(".category_nav_inner li").removeClass("prod_nav");
            $(this).addClass("prod_nav")
            console.log(catId);
            $("#search").val('')
            searchNView('', catId);

        }

    });
    $("#removeAllFromCart").hover(function () {
        // over
        $(this).css('color', "rgba(255, 104, 3, 0.795)")
        $("#counter_body ol").css("opacity", "50%")

    }, function () {
        // out
        $(this).css('color', "rgb(199, 199, 199)")
        $("#counter_body ol").css("opacity", "100%")
 

    }
    );




    function removeAllFromCart(formData, transac) {
        formData.append("transac", transac);


        $('#counter_body ol').addClass("removeItem");
        setTimeout(() => {
            $('#counter_body ol').removeClass("removeItem");
            $('#counter_body ol').remove();
        }, 250);

        $.ajax({
            url: '../Views/cashierView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (!response) {
                    $('#counter_body').html(`<div class="noItem">Cart is empty...</div>`);

                } 

            }
        });

    }



    function addToCart(formData, tr, p_id, product_name, price) {

        formData.append("transac", tr);



        $.ajax({
            url: '../Views/cashierView.php',
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

    function searchNView(searchVal, category_id) {
        formData = new FormData();
        formData.append("searchVal", searchVal)
        formData.append("transac", "searchNView")
        formData.append("category_id", category_id)

        $.ajax({
            url: '../Views/cashierView.php',
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.products_content').html(response);
                $('.products_content').children().hide();


                $('.products_content').children().each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });
            }
        });
    }

    function getCategory() {
        formData = new FormData();
        formData.append("transac", "getCateguri")

        $.ajax({
            url: '../Views/cashierView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.category_nav_inner').html(response);
                $('.category_nav_inner li').hide();
                $(".category_nav_inner li").each(function (index) {
                    $(this).delay(index * 200).fadeIn(250);
                });
            },
            complete: function () {


            }
        });
    }



});
