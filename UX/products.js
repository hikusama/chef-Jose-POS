




$(document).ready(function () {
    addPorm = $("#addProductForm").detach();
    addCat = $(".categoryForm-outer").detach();
    let comboAdd = $(".comboAdd-form-cont").detach();

    // $(".myproducts").detach(addPorm);
    $("#addProductForm").detach();
    // $(".categoryForm-outer").detach();
    let actionSelect;
    reqOpen = false;
    allProducts("");

    open_Insertion = true;
    let findPr
    let viewSel
    let interval = "";
    // });

    let prdShowState = true;
    $(".myproducts").on("change", "#selectComboPic", function (e) {
        e.preventDefault();
        imagePick("#comboDP", "#selectComboPic");

    });
    $("#content_products-cont").on("click", "#prdType", function (e) {
        e.preventDefault();
        if (prdShowState == false && reqOpen == true) {
            reqOpen = false;
            prdShowState = true;
            $("#content_products-cont ol").html(`<h5>DP</h5><h5>Product</h5><h5>Category</h5><h5>Stock</h5><h5>Price</h5><h5></h5><div class="showType"><button type="button" id="prdType" class="state">Products</button><button type="button" id="cmboType" >Combo's</button></div>`)
            $("#content_products >*").addClass("changeComboSec")
            setTimeout(() => {
                $("#content_products >*").removeClass("changeComboSec")
                $("#content_products >*").detach()
            allProducts("")
        }, 250);
            $("#findComboExec").attr("placeholder", "Seach for products...");
            $("#findComboExec").attr("id", "findExec");
        }
        // console.log("prd: ",prdShowState,"\nopen?: ",reqOpen);

    });
    $("#content_products-cont").on("click", "#cmboType", function (e) {
        e.preventDefault();
        if (prdShowState == true && reqOpen == true) {
            prdShowState = false;
            reqOpen = false;
            $("#content_products-cont ol").html(`<h5>DP</h5><h5>Name</h5><h5>Code</h5><h5>Items</h5><h5>Price</h5><h5></h5><div class="showType"><button type="button" id="prdType" >Products</button><button type="button" id="cmboType" class="state">Combo's</button></div>`)
            $("#content_products >*").addClass("changeComboSec")
            setTimeout(() => {
                $("#content_products >*").removeClass("changeComboSec")
                $("#content_products >*").detach()
            allCombo("")

            }, 250);
            $("#findExec").attr("placeholder", "Seach for combo's or code...");
            $("#findExec").attr("id", "findComboExec");
        }
            // console.log("prd: ",prdShowState,"\nopen?: ",reqOpen);
            
    });



    $(".myproducts").on("submit", "#addComboForm", function (ae) {
        ae.preventDefault()

        formData = new FormData(this)
        formData.append("transac", "insertCombo")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (response) {
                    $('.combo-response').html(response);
                } else {
                    $(".myproducts #addComboForm input").val("");
                    $(".combo-response").html("");
                    $(".exit").trigger("click");
                    notify("Combo added successfully...")
                }
            }
        });

    });


    $(".myproducts").on("click", "#submit-combo_form", function (e) {
        e.preventDefault()
        console.log(454545454);

        $("#addComboForm").trigger("submit");
    });




    $(".myproducts").on("click", "#rmSelectedCombo", function (e) {
        e.preventDefault()
        prodIDSel = $(this).parent().attr('id')
        deselectProd(prodIDSel)
        $(this).closest('ol').addClass('ol_anim_rm')
        setTimeout(() => {
            $(this).closest('ol').detach()
        }, 220);

    });




    $(".myproducts").on("click", "#selectProd", function (e) {
        e.preventDefault()
        prodIDSel = $(this).parent().attr('id')
        selectProd(prodIDSel)
        $(this).closest('ol').addClass('ol_anim_sel')
        setTimeout(() => {
            $(this).closest('ol').detach()
            T = $(".data-products").html().trim();
            $(".data-products").addClass('unsd');
            if (T == "") {
                console.log(200);
                $(".data-products").html("No products..");
            } else {
                console.log(404);
            }
        }, 220);
    });


    $(".myproducts").on("input", "#findProdInput", function (e) {
        e.preventDefault()
        comboShowProd($(this).val())
    });





    let clickedFnd = false
    $(".myproducts").on("click", "#addRm-combo", function (e) {
        e.preventDefault();

        if (!clickedFnd) {
            $(this).html(`<i class="fas fa-eye"></i>View selected`)
            console.log(1);
            clickedFnd = true
            $(viewSel).detach()
            $(".action-products").append(findPr)
            comboShowProd("")

        } else {
            $(findPr).detach()
            $(".action-products").append(viewSel)
            viewSelectedCombo();

            console.log(2);
            clickedFnd = false
            $(this).html(`<i class="fas fa-search"></i>Find producs`)
            // $(".data-products ol").removeClass("new-data-products");
            $('.data-products').html("");


        }
    });



    let norun = true
    $("#addCombo").click(function (e) {
        e.preventDefault();
        $("#overlay_prod").show();
        $(".myproducts").append(comboAdd)

        $(".comboAdd-form-cont").show();
        if (norun == true) {
            findPr = $("#findProdController").detach();
            viewSel = $("#viewSel").detach();
            norun = false
        }
        if (clickedFnd) {
            $(viewSel).detach()
            $(".action-products").append(findPr)
        } else {
            $(findPr).detach()
            $(".action-products").append(viewSel)
            viewSelectedCombo();

        }

        $(".action-products-outer").show();
        loadScCombo("sh")
        setTimeout(() => {
            loadScCombo("rm")
        }, 500);
    });


    $(".myproducts").on("click", ".exit", function () {
        $(comboAdd).detach()
        $("#overlay_prod").hide();
    });


    $("#addProduct").click(function (e) {
        e.preventDefault();
        if (open_Insertion) {
            formData = new FormData()

            formData.append("transac", "getCategory")
            $.ajax({
                url: '../views/productView.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#prod_category').html(response);
                }
            });
            $("#overlay_prod").show();
            $(".myproducts").append(addPorm);

            setTimeout(() => {
                console.log("sada");
                $(".label_style").addClass("newlabel_style");
            }, 600);

            interval = setInterval(() => {
                manipulated = $("#overlay_prod").css("display", "none");
                if (manipulated) {
                    $("#overlay_prod").show();
                }
            }, 800);

            open_Insertion = false;

        }

    });


    $(".myproducts").on("change", "#addpic", function (e) {
        e.preventDefault();
        const input = $('#addpic')[0];
        console.log("entered111");

        if (input) {
            imagePick("#imgdisplay", "#addpic");
        }
    });



    $(".myproducts").on("click", "#canc", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval)
        $(".label_style").removeClass("newlabel_style");
        $("#overlay_prod").hide();
        $("#addProductForm").detach();


    });

    // $("#submit_prod").click(function (e) { 
    //     $("#submit_form").submit(); 
    // });  method="post" action="../views/productView.php"


    $(".myproducts").on("submit", "#submit_form", function (e) {
        e.preventDefault();
        formData = new FormData(this)
        formData.append("transac", "addProd")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (response == "productAdded") {
                    notify("Product Added Successfully")
                    open_Insertion = true;
                    clearInterval(interval)
                    $("#imgdisplay").attr('src', '../image/dpTemplate.png');
                    allProducts("")
                    $(".label_style").removeClass("newlabel_style");
                    $("#overlay_prod").hide();
                    $("#addProductForm input").val("");
                    $("#addProductForm .response").html("");

                    $("#addProductForm").detach();


                }
                $('.response').html(response);
            }
        });

    });



    $("#content_products").on("click", ".more_showPane", function (e) {
        e.preventDefault();
        // console.log(54444444444444444);
        hasClass = $(this).closest("li").find(".action_selectNew").hasClass("action_selectNew");

        if (!hasClass) {
            console.log("hello");
            $("#content_products li").css("z-index", "1");
            $(this).closest("li").css("z-index", "2");
            $("#content_products .action_select").removeClass("action_selectNew");
            $(this).closest("li").find(".action_select").addClass("action_selectNew");
            // $(this).closest("li").append(actionSelect);
        } else {

            $("#content_products .action_select").removeClass("action_selectNew");
            // $(".action_select").detach();

        }
        // new_id = $(this).closest("#content_products li").find(".action_select").attr("id");
        // console.log(new_id);

        // if (clicked_count == 2) {
        //     prev_clicked = 1;
        //     clicked_count = 1;
        // }
        // if (prev_clicked != new_id) {
        //     $(this).closest("li").append(actionSelect);

        // } else if (clicked_count == 1) {
        //     // $(this).closest("li").find(".action_select").detach();
        //     $(".action_select").detach();
        // } else {
        //     $(".action_select").detach();
        //     $(this).closest("li").append(actionSelect);
        // }
        // clicked_count = clicked_count + 1;

        // prev_clicked = new_id;


    });


    let interval2 = "";

    $("#addCategory").click(function (e) {
        e.preventDefault();
        if (open_Insertion) {

            $("#overlay_prod").show();
            $(".myproducts").append(addCat);
            $(".uiInfo").hide();

            setTimeout(() => {
                $(".uiInfo").fadeIn(200);
            }, 600);

            interval2 = setInterval(() => {
                manipulated = $("#overlay_prod").css("display", "none");
                if (manipulated) {
                    $("#overlay_prod").show();
                }
                console.log('ngiao');

            }, 800);
            open_Insertion = false;
        }
    });

    $(".myproducts").on("click", "#cancelAddCat", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval2)
        $(".uiInfo").hide();
        $("#overlay_prod").hide();
        $(".categoryForm-outer").detach();
    });


    $(".myproducts").on("submit", "#category", function (e) {
        e.preventDefault()
        formData = new FormData(this)
        formData.append("transac", "addCategory")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                response = response.trim()
                if (response == "categoryAdded") {
                    notify("Category Added Successfully")
                    open_Insertion = true;
                    clearInterval(interval2)

                    $("#categoryForm .category-response").html("");
                    $("#categoryForm input").val("");
                    $(".uiInfo").hide();
                    $("#overlay_prod").hide();
                    $(".categoryForm-outer").detach();
                    allProducts("")
                }
                $('.category-response').html(response);
            }
        });

    });


    $(".find_prod").on("input", "#findComboExec", function () {

        allCombo($(this).val())

    });
    $(".find_prod").on("input", "#findExec", function () {

        allProducts($(this).val())

    });






    $("#content_products").on("click", "", function () {

    });




});


function deselectProd(prodIDSel) {

    formData = new FormData()
    formData.append("productID", prodIDSel)
    formData.append("transac", "rmSelectedProd")

    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            response = response.trim()
            if (response == "No products..") {

                $(".data-products-selected").html(response);
            }
        }, complete: function () {
            viewComboSum();

        }
    });
}
function selectProd(prodIDSel) {

    formData = new FormData()
    formData.append("productID", prodIDSel)
    formData.append("transac", "selectProd")

    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            response = response.trim()
            $(".data-products .loadingScComboForm-outer").detach();

        }, complete: function () {
            viewComboSum();

        }
    });


}
function loadScCombo(action) {

    if (action == "sh") {
        $(".loadingScComboForm").removeClass("newLoadingScComboForm");
        $(".loadingScComboForm, .data-products").css("height", "10rem");
        $(".loadingScComboForm, .data-products-selected").css("height", "11rem");
    } else {
        $(".loadingScComboForm").addClass("newLoadingScComboForm");
        $(".loadingScComboForm, .data-products").css("height", "fit-content");
        $(".loadingScComboForm, .data-products-selected").css("height", "fit-content");
    }

}


function viewComboSum() {
    formData = new FormData()
    formData.append("transac", "viewComboSummary")

    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('.data_summary_combo').html(response);
        }
    });

}
let runOnce = false
function viewSelectedCombo() {
    loadScCombo("sh")

    formData = new FormData()
    formData.append("transac", "viewSelectedProd")

    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('.data-products-selected').html(response);
            // $(".data-products ol").addClass("new-data-products");

            // $(".loading_sc").parent().css("overflow-y", "hidden");
            // setTimeout(() => {
            //     $(".data-products ol").each(function (index) {
            //         if (index > 1) {
            //             $(this).delay(index * 100).fadeIn(200);   
            //         }
            //     });
            //     // $(".loading_sc").parent().css("overflow-y", "scroll");
            // }, 1500);

        }, complete: function () {
            setTimeout(() => {
                loadScCombo("rm")
            }, 500);
            $(".data-products-selected ol").addClass("new-data-products");
            if (runOnce == false) {
                viewComboSum();
                runOnce = true
            }
        }
    });


}

function comboShowProd(search) {
    loadScCombo("sh")

    formData = new FormData()
    formData.append("transac", "comboSectionShowSearchProd")
    formData.append("name", search)



    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('.data-products').html(response);
            // $(".data-products ol").addClass("new-data-products");

            // $(".loading_sc").parent().css("overflow-y", "hidden");
            // setTimeout(() => {
            //     $(".data-products ol").each(function (index) {
            //         if (index > 1) {
            //             $(this).delay(index * 100).fadeIn(200);   
            //         }
            //     });
            //     // $(".loading_sc").parent().css("overflow-y", "scroll");
            // }, 1500);

        }, complete: function () {
            setTimeout(() => {
                loadScCombo("rm")
            }, 500);
            $(".data-products ol").addClass("new-data-products");

        }
    });
}



function allCombo(comboName) {
    formData = new FormData()
    formData.append("transac", "findCombo")
    formData.append("comboName", comboName)

    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#content_products').html("");
            $('#content_products').append(response);
            $('#content_products li').hide();
            $(".loading_sc").show();
            // $(".loading_sc").parent().css("overflow-y", "hidden");
            setTimeout(() => {
                $(".loading_sc").hide();
                $("#content_products li").each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });
                // $(".loading_sc").parent().css("overflow-y", "scroll");
            return reqOpen = true
            }, 1500);
        }
    });
}

function allProducts(searchArg) {
    // hasClass = $("#content_products").children().hasClass("loading_sc");
    $('#content_products li').hide();
    $(".loading_sc").show();

    formData = new FormData()
    formData.append("transac", "showSearchProd")
    formData.append("name", searchArg)
    // if (hasClass) {
    //     $(".loading_sc").show();
    // }else{
    //     console.log("helll");

    //     $('#content_products li').detach();
    //     $('#content_products').append(loading_sc);

    // }


    $.ajax({
        url: '../views/productView.php',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            $('#content_products').html("");
            $('#content_products').append(response);
            $('#content_products li').hide();
            $(".loading_sc").show();
            // $(".loading_sc").parent().css("overflow-y", "hidden");
            setTimeout(() => {
                $(".loading_sc").hide();
                $("#content_products li").each(function (index) {
                    $(this).delay(index * 100).fadeIn(200);
                });
                // $(".loading_sc").parent().css("overflow-y", "scroll");
            return reqOpen = true
            }, 1500);
        }
    });
}

function notify(msg) {
    notif = `<div class="notification">
                    <i class="fas fa-check"></i>
                    <h5>${msg}...</h5>
                </div>`;
    $(".myproducts").append(notif);

    setTimeout(() => {
        $(".notification i").css("animation-name", "on_notif");
    }, 1500);

    setTimeout(() => {
        $(".notification").css("transform", "translateX(20rem)");
    }, 4000);

    setTimeout(() => {
        $(".notification").detach();
    }, 6000);
}


function imagePick(dp, inpt) {
    const profileImage = $(dp);
    const input = $(inpt)[0];
    const file = input.files[0];
    console.log("entered");

    if (file) {
        const reader = new FileReader();
        reader.onload = function () {
            profileImage.attr('src', reader.result);
        };
        reader.readAsDataURL(file);
        console.log("readed");
        console.log(1);

    } else {
        console.log(404);

        profileImage.attr('src', '../image/dpTemplate.png');

    }

}