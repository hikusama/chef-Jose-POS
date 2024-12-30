




$(document).ready(function () {
    let loadNt = $("#loadNt").detach();
    $(".loadPa").html(loadNt);
    let loadNtCombo = $(".loadPa").detach();
    let addPorm = $("#addProductForm").detach();
    let addCat = $(".categoryForm-outer").detach();
    let comboAdd = $(".comboAdd-form-cont").detach();

    let editPorm = $("#editProductForm").detach();
    let editCat = $(".editcategoryForm-outer").detach();
    let editCombo = $(".comboEdit-form-cont").detach();
    let orgProdData = [];
    let orgComboData = [];
    let orgCatData = [];
    let imgChangeProd = 0
    let imgChange = 0

    // $(".myproducts").detach(addPorm);
    $("#addProductForm").detach();
    // $(".categoryForm-outer").detach();
    reqOpen = false;
    allProducts("");
    let prdShowState = 1;

    let clickedFnd = false
    let clickedFndEdit = false
    let norun = true
    let norunEdit = true
    open_Insertion = true;
    let findPrEdit
    let findPr
    let viewSelEdit
    let viewSel
    let interval = "";
    // });

    // validation front-end product Edit 

    $(".myproducts").on("change", "#editProductForm select", function (e) {
        e.preventDefault()
        $(".myproducts #editProductForm .actr").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".myproducts #editProductForm .actr").attr(`value`, `check`)
        $(".myproducts #editProductForm .actr").attr(`id`, `validateProd`)
        $(".responseedit").html("")
    });

    $(".myproducts").on("input", "#editProductForm input", function (e) {
        e.preventDefault()
        $(".myproducts #editProductForm .actr").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".myproducts #editProductForm .actr").attr(`value`, `check`)
        $(".myproducts #editProductForm .actr").attr(`id`, `validateProd`)
        $(".responseedit").html("")
    });
    $(".myproducts").on("input", "#prod_priceedit", function (e) {
        e.preventDefault()
        val = $(this).val().trim()

        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgProdData.price) {
            $(this).addClass("modif")
        }
    });

    $(".myproducts").on("input", "#prod_nameedit", function (e) {
        e.preventDefault()
        val = $(this).val().trim()

        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgProdData.name) {
            $(this).addClass("modif")
        }
    });

    $(".myproducts").on("change", "#availabilityedit", function (e) {
        e.preventDefault()
        val = $(this).val().trim()

        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgProdData.availability) {
            $(this).addClass("modif")
        }
    });

    $(".myproducts").on("change", "#prod_category", function (e) {
        e.preventDefault()
        val = $(this).val().trim()

        $(this).removeClass("modif")
        $(this).removeClass("emptyI")

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgProdData.categoryID) {
            $(this).addClass("modif")
        }
    });







    // validation front-end Category Edit 
    $(".myproducts").on("input", "#editCatInput", function (e) {
        e.preventDefault()
        val = $(this).val().trim()

        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        $(".myproducts #editcategory button").html(`<i class="fas fa-check-square"></i> Validate`)
        $(".myproducts #editcategory button").attr(`value`, `check`)
        $(".myproducts #editcategory button").attr(`id`, `validateCat`)
        $(".editcategory-response").html("")

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgCatData) {
            $(this).addClass("modif")
        }

    });













    // validation front-end Combo Edit 

    $(".myproducts").on("input", "#comboNameEdit", function (e) {
        e.preventDefault();
        val = $(this).val().trim()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        console.log(orgComboData);
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);


        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgComboData.comboName) {
            $(this).addClass("modif")
        }
    })

    $(".myproducts").on("input", "#comboPriceEdit", function (e) {
        e.preventDefault();
        val = $(this).val().trim()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgComboData.comboPrice) {
            $(this).addClass("modif")
        }
    })


    $(".myproducts").on("input", "#comboCodeEdit", function (e) {
        e.preventDefault();
        val = $(this).val().trim()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgComboData.comboCode) {
            $(this).addClass("modif")
        }
    })

    $(".myproducts").on("change", "#availEdit", function (e) {
        e.preventDefault();
        val = $(this).val().trim()
        $(this).removeClass("modif")
        $(this).removeClass("emptyI")
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);

        console.log(val);

        if (val === "") {
            $(this).addClass("emptyI")
        } else if (val != orgComboData.availability) {
            $(this).addClass("modif")
        }
    })














    $(".myproducts").on("click", "#editByID", function (e) {
        e.preventDefault()
        id = parseInt($(this).parent().attr("id"))
        $("#editsubmit_form").html("");
        $("#editProductForm").show();

        $("#overlay_prod").show();
        if (prdShowState == 1) {
            $(".myproducts").append(editPorm);
            $(editPorm).show();
        } else if (prdShowState == 2) {
            $(".myproducts").append(editCat);
            $(editCat).show();
        } else if (prdShowState == 3) {
            dumpProdIDs(id)
            $(".myproducts").append(editCombo);
            $(editCombo).show();
        }
        getEditForm(id)



        interval = setInterval(() => {
            manipulated = $("#overlay_prod").css("display", "none");
            if (manipulated) {
                $("#overlay_prod").show();
            }
        }, 800);
        open_Insertion = false;
    });


    $(".myproducts").on("click", "#deleteByID", function (e) {
        e.preventDefault()
        id = parseInt($(this).parent().attr("id"))
        if (prompt("Type 'delete' to confirm.") === "delete") {

            deleteThings(id)
            $(".more_showPane").trigger("click");
            $("#content_products .action_select").removeClass("action_selectNew");
            $(this).closest('li').addClass('delItem')
            setTimeout(() => {
                $(this).closest('li').detach()
            }, 300);

        }


    });


    $(".myproducts").on("click", ".main-dir-link button", function (e) {
        e.preventDefault()
        let page = $(this).attr("id")
        let searchVal
        if (page != "pageON") {

            if (prdShowState == 1) {
                searchVal = $("#findExec").val()
                allProducts(searchVal, parseInt($(this).attr("id")))
            } else if (prdShowState == 2) {
                searchVal = $("#findCatExec").val()
                allCat(searchVal, parseInt($(this).attr("id")))
            } else if (prdShowState == 3) {
                searchVal = $("#findComboExec").val()
                allCombo(searchVal, parseInt($(this).attr("id")))
            }
        }
    });


    $(".myproducts").on("change", "#selectComboPic", function (e) {
        e.preventDefault();
        imagePick("#comboDP", "#selectComboPic");

    });
    $(".myproducts").on("change", "#selectComboPicEdit", function (e) {
        e.preventDefault();
        imagePick("#comboDPEdit", "#selectComboPicEdit", 2);
        imgChange = 1
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);

    });
    $("#content_products-cont").on("click", "#prdType", function (e) {
        e.preventDefault();
        if (prdShowState != 1 && reqOpen == true) {
            reqOpen = false;
            prdShowState = 1;
            $("#content_products-cont ol").html(`<h5>DP</h5><h5>Product</h5><h5>Category</h5><h5>Availability</h5><h5>Price</h5><h5></h5><div class="showType"><button type="button" id="prdType" class="state">Products</button><button type="button" id="catType" >Categories</button><button type="button" id="cmboType" >Combo's</button></div>`)
            $("#content_products >*").addClass("changeComboSec")
            setTimeout(() => {
                $("#content_products >*").removeClass("changeComboSec")
                $("#content_products >*").detach()
                allProducts("")
            }, 250);
            $(".find_prod input").val("");
            $(".find_prod input").attr("placeholder", "Search for products or category...");
            $(".find_prod input").attr("id", "findExec");
        }

    });
    $("#content_products-cont").on("click", "#catType", function (e) {
        e.preventDefault();
        if (prdShowState != 2 && reqOpen == true) {
            reqOpen = false;
            prdShowState = 2;
            $("#content_products-cont ol").html(`<h5>Products</h5><h5>Category name</h5><h5></h5><h5></h5><h5></h5><h5></h5><div class="showType"><button type="button" id="prdType" >Products</button><button type="button" class="state" id="catType" >Categories</button><button type="button" id="cmboType" >Combo's</button></div>`)
            $("#content_products >*").addClass("changeComboSec")
            setTimeout(() => {
                $("#content_products >*").removeClass("changeComboSec")
                $("#content_products >*").detach()
                allCat("")
            }, 250);
            $(".find_prod input").val("");
            $(".find_prod input").attr("placeholder", "Search a category...");
            $(".find_prod input").attr("id", "findCatExec");
        }

    });
    $("#content_products-cont").on("click", "#cmboType", function (e) {
        e.preventDefault();
        if (prdShowState != 3 && reqOpen == true) {
            prdShowState = 3;
            reqOpen = false;
            $("#content_products-cont ol").html(`<h5>DP</h5><h5>Name/Code</h5><h5>Items</h5><h5>Availability</h5><h5>Price</h5><h5></h5><div class="showType"><button type="button" id="prdType" >Products</button><button type="button" id="catType" >Categories</button><button type="button" id="cmboType" class="state">Combo's</button></div>`)
            $("#content_products >*").addClass("changeComboSec")
            setTimeout(() => {
                $("#content_products >*").removeClass("changeComboSec")
                $("#content_products >*").detach()
                allCombo("")
            }, 250);
            $(".find_prod input").val("");
            $(".find_prod input").attr("placeholder", "Search for combo's or code...");
            $(".find_prod input").attr("id", "findComboExec");
        }

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
                    prdShowState = 3
                    $("#cmboType").trigger("click");
                    notify("Combo added successfully...")
                }
            }
        });

    });


    $(".myproducts").on("submit", "#editComboForm", function (ae) {
        ae.preventDefault()
        id = parseInt($("#editByID").parent().attr("id"))

        formData = new FormData(this)
        formData.append("transac", "comboDoubleAction")
        formData.append("reqType", "check")
        formData.append("comboID", id)
        formData.append("imgChanges", imgChange)

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "minorerr") {
                    $('#submitChanges').attr('id', "validate");
                    $('#validate').html('<i class="fas fa-check-square"></i>Validate');
                    $('.combo-response').html(`<p>${response.msg}</p>`);
                } else {
                    if (response.res === "checked") {
                        $('#validate').html('<i class="fas fa-plus"></i>Submit changes');
                        $('#validate').attr('id', "submitChanges");
                        $('.combo-response').html(response.msg);

                    } else if (response.res === "executed") {
                        if (response.msg === "success") {

                            $(".myproducts #editComboForm input").val("");
                            $(".combo-response").html("");
                            $(".exitEdit").trigger("click");
                            prdShowState = 3
                            $("#cmboType").trigger("click");
                            notify("Combo Updated successfully...")
                        }
                    }
                }
            }
        });

    });


    $(".myproducts").on("click", "#submit-combo_form", function (e) {
        e.preventDefault()
        $("#addComboForm").trigger("submit");
    });

    $(".myproducts").on("click", "#validate", function (e) {
        e.preventDefault()
        $("#editComboForm").trigger("submit");
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


    $(".myproducts").on("click", "#rmSelectedComboEdit", function (e) {
        e.preventDefault()
        prodIDSel = $(this).parent().attr('id')
        deselectProdEdit(prodIDSel)
        $(this).closest('ol').addClass('ol_anim_rm')
        setTimeout(() => {
            $(this).closest('ol').detach()
        }, 220);
        $('.new-data-products').addClass("modif")
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);
        $(".data_summary_combo_edit").css("color", "#00dd00")
    });


    let lastitemEdit;


    $(".myproducts").on("click", "#selectProdEdit", function (e) {
        e.preventDefault()
        prodIDSel = $(this).parent().attr('id')
        lastitemEdit = $(this).closest('ol').html()
        selectProdEdit(prodIDSel)
        $(this).closest('ol').addClass('ol_anim_sel')
        setTimeout(() => {
            $(this).closest('ol').detach()
            T = $(".data-products").html().trim();
            $(".data-products").addClass('unsd');
            if (T == "") {
                $(".data-products").html("No products..");
            } else {
            }
        }, 220);
        $('#submitChanges').attr('id', "validate");
        $('#validate').html('<i class="fas fa-check-square"></i>Validate');
        $('.combo-response').html(`<div class="waiting"><p></p><p></p><p></p><p></p></div>`);
        $(".data_summary_combo_edit").css("color", "#00dd00")

    });
    let lastitem;

    $(".myproducts").on("click", "#selectProd", function (e) {
        e.preventDefault()
        prodIDSel = $(this).parent().attr('id')
        lastitem = $(this).closest('ol').html()
        selectProd(prodIDSel)
        $(this).closest('ol').addClass('ol_anim_sel')
        setTimeout(() => {
            $(this).closest('ol').detach()
            T = $(".data-products").html().trim();
            $(".data-products").addClass('unsd');
            if (T == "") {
                $(".data-products").html("No products..");
            } else {
            }
        }, 220);
    });


    $(".myproducts").on("input", "#findProdInput", function (e) {
        e.preventDefault()
        comboShowProd($(this).val())
    });
    $(".myproducts").on("input", "#findProdInputEdit", function (e) {
        e.preventDefault()
        comboShowProdEdit($(this).val())
    });






    $(".myproducts").on("click", "#addRm-combo", function (e) {
        e.preventDefault();

        if (!clickedFnd) {
            $(this).html(`<i class="fas fa-eye"></i>View selected`)
            clickedFnd = true
            $(viewSel).detach()
            $(".action-products").append(findPr)
            comboShowProd("")

        } else {
            $(findPr).detach()
            $(".action-products").append(viewSel)
            viewSelectedCombo();

            clickedFnd = false
            $(this).html(`<i class="fas fa-search"></i>Find products`)
            // $(".data-products ol").removeClass("new-data-products");
            $('.data-products').html("");


        }
    });
    $(".myproducts").on("click", "#addRm-comboEdit", function (e) {
        e.preventDefault();
        id = parseInt($("#editByID").parent().attr("id"))

        if (!clickedFndEdit) {
            $(this).html(`<i class="fas fa-eye"></i>View selected`)
            clickedFndEdit = true
            $(viewSelEdit).detach()
            $(".action-products").append(findPrEdit)
            comboShowProdEdit("")
        } else {
            $(findPrEdit).detach()
            $(".action-products").append(viewSelEdit)
            viewSelectedDumpedProd(id)
            viewComboSumEdit()
            clickedFndEdit = false
            $(this).html(`<i class="fas fa-search"></i>Find products`)
            // $(".data-products ol").removeClass("new-data-products");
            $('.data-products').html("");


        }
    });



    $("#addCombo").click(function (e) {
        e.preventDefault();
        $("#overlay_prod").show();
        $(".myproducts").append(comboAdd)
        $(".comboAdd-form-cont").show();

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





    $(".myproducts").on("click", ".exitedit", function () {
        $(".comboEdit-form-inner").html('');
        $(editCombo).detach()
        $("#overlay_prod").hide();
        clearInterval(interval)
        un()

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
            $("#addProductForm").show();


            setTimeout(() => {
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


    $(".myproducts").on("change", "#addpicedit", function (e) {
        e.preventDefault();

        imagePick("#editimgdisplay", "#addpicedit", 3);
        imgChangeProd = 1

    });


    $(".myproducts").on("change", "#addpic", function (e) {
        e.preventDefault();

        imagePick("#imgdisplay", "#addpic");

    });



    $(".myproducts").on("click", "#cancedit", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval)
        $(".label_style").removeClass("newlabel_style");
        $("#overlay_prod").hide();
        $("#editsubmit_form").html("");
        $("#editProductForm").detach();


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
                    if (prdShowState != 1) {
                        $("#prdType").trigger("click");
                    } else {
                        allProducts("")
                    }
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

    $(".myproducts").on("submit", "#editsubmit_form", function (e) {
        e.preventDefault();
        reqtype = $("#editsubmit_form .actr").attr("value")
        id = parseInt($("#editByID").parent().attr("id"))

        formData = new FormData(this)
        formData.append("transac", "editProd")
        formData.append("imgChange", imgChangeProd)
        formData.append("id", id)
        formData.append("reqtype", reqtype)

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.responseedit').html(response.msg);
                if (response.res !== "minorerr") {
                    if (response.res === "no error") {
                        $("#validateProd").html(`<i class="fas fa-plus"></i> Submit changes`)
                        $("#validateProd").attr(`value`, `update`)
                        $("#validateProd").attr(`id`, `submit_editprod`)
                    } else if (response.res === "success") {
                        $("#cancedit").trigger("click");
                        prdShowState = 1
                        allProducts("", 1)
                        notify(response.msg)
                    } else {
                        $("#submit_editprod").html(`<i class="fas fa-check-square"></i> Validate`)
                        $("#submit_editprod").attr(`value`, `check`)
                        $("#submit_editprod").attr(`id`, `validateProd`)
                    }
                }
            }
        });

    });



    $("#content_products").on("click", ".more_showPane", function (e) {
        e.preventDefault();
        hasClass = $(this).closest("li").find(".action_selectNew").hasClass("action_selectNew");

        if (!hasClass) {
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
            $(".categoryForm-outer").show();

            $(".uiInfo").hide();

            setTimeout(() => {
                $(".uiInfo").fadeIn(200);
            }, 600);

            interval2 = setInterval(() => {
                manipulated = $("#overlay_prod").css("display", "none");
                if (manipulated) {
                    $("#overlay_prod").show();
                }

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

    $(".myproducts").on("click", "#cancelEditCat", function (e) {
        e.preventDefault();
        open_Insertion = true;
        clearInterval(interval)
        $(".uiInfo").hide();
        $("#overlay_prod").hide();
        $(".editcategoryForm-outer").detach();
    });


    $(".myproducts").on("submit", "#editcategory", function (e) {
        e.preventDefault()
        formData = new FormData(this)

        editCatSubmit(formData)

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
                    prdShowState = 2
                    $("#categoryForm .category-response").html("");
                    $("#categoryForm input").val("");
                    $(".uiInfo").hide();
                    $("#overlay_prod").hide();
                    $(".categoryForm-outer").detach();
                    allCat("", 1)
                }
                $('.category-response').html(response);
            }
        });

    });


    $(".find_prod").on("input", "#findExec", function () {

        allProducts($(this).val())

    });
    $(".find_prod").on("input", "#findCatExec", function () {

        allCat($(this).val())

    });
    $(".find_prod").on("input", "#findComboExec", function () {

        allCombo($(this).val())

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
                if (response.res === "error") {
                    ab = `<ol class="new-data-products">${lastitem}</ol>`
                    $(".data-products").append(ab);
                    $(ab).show()
                    $('.combo-response').html(response.msg);
                }
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

            }, complete: function () {
                setTimeout(() => {
                    loadScCombo("rm")
                }, 500);
                $(".data-products ol").addClass("new-data-products");

            }
        });
    }

    function allCat(catName, page = 1) {
        formData = new FormData()
        formData.append("transac", "findCat")
        formData.append("page", page)
        formData.append("catName", catName)

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

    function allCombo(comboName, page = 1) {
        formData = new FormData()
        formData.append("transac", "findCombo")
        formData.append("page", page)
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

    function allProducts(searchArg, page = 1) {
        // hasClass = $("#content_products").children().hasClass("loading_sc");
        $('#content_products li').hide();
        $(".loading_sc").show();

        formData = new FormData()
        formData.append("page", page)
        formData.append("transac", "showSearchProd")
        formData.append("name", searchArg)
        // if (hasClass) {
        //     $(".loading_sc").show();
        // }else{

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



    // ACTION

    function getEditForm(id) {
        formData = new FormData()
        formData.append("ID", id)
        formData.append("transac", "fetchDataAction")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.formType === "products") {
                    $("#editsubmit_form").html(response.form);
                    $("#editsubmit_form > *").hide()
                    $("#editsubmit_form").append(loadNt);
                    $(loadNt).show()
                    insertF($("#editsubmit_form #editimgdisplay").attr('src'), '#addpicedit')

                    orgProdData = response.orgData

                    setTimeout(() => {
                        $(loadNt).detach()
                        $("#editsubmit_form > *").show()
                        $("#editsubmit_form .label_style").hide()
                        setTimeout(() => {
                            $(".label_style").addClass("newlabel_style");
                        }, 600);
                    }, 800);
                } else if (response.formType === "category") {
                    $("#editcategoryForm").html(response.form);
                    $("#editcategoryForm > *").hide()
                    $("#editcategoryForm").append(loadNt);
                    $(loadNt).show()

                    orgCatData = response.orgData

                    setTimeout(() => {
                        $(loadNt).detach()
                        $("#editcategoryForm > *").show()
                        $("#editcategoryForm .label_style").hide()
                        setTimeout(() => {
                            $(".label_style").addClass("newlabel_style");
                        }, 600);
                    }, 800);
                } else if (response.formType === "combo") {
                    // loadNtCombo = 

                    $(".comboEdit-form-inner").html(response.form);
                    insertF($(".comboEdit-form-inner #comboDPEdit").attr('src'), '#selectComboPicEdit')
                    $(".comboEdit-form-inner > *").hide()
                    $(".comboEdit-form-inner").append(loadNtCombo);
                    $(loadNtCombo).html(loadNt)
                    $(loadNt).show()

                    orgComboData = response.orgData

                    setTimeout(() => {
                        $(loadNtCombo).detach()
                        $(".comboEdit-form-inner > *").show()
                        $(".action-products-outer").show();

                    }, 800);
                    if (norunEdit == true) {
                        findPrEdit = $("#findProdControllerEdit").detach();
                        viewSelEdit = $("#viewSelEdit").detach();
                        norunEdit = false
                    }
                    $(".action-products").html(viewSelEdit)
                    viewSelectedDumpedProd(id)
                    // if (clickedFndEdit) {
                    //     $(viewSelEdit).detach()
                    //     $(".action-products").html(findPrEdit)
                    //     $("#addRm-comboEdit").html(`<i class="fas fa-eye"></i>View selected`)
                    // } else {
                    //     $(findPrEdit).detach()
                    //     $("#addRm-comboEdit").html(`<i class="fas fa-search"></i>Find products`)

                    // }
                    // console.log(clickedFndEdit);


                }
            }
        });
    }

    function updateThings(id) {

        formData = new FormData(this)
        formData.append("ID", id)
        formData.append("transac", "updateAction")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.result == "Updated") {
                    notify("Updated successfully...")
                }
            }
        });

    }


    function deleteThings(id) {

        formData = new FormData()
        formData.append("ID", id)
        formData.append("transac", "removeAction")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.result == "Deleted") {
                    notify("Deleted successfully...")
                }
            }
        });

    }

    function insertF(imgSrc, inputFile) {
        let input3 = $(inputFile)[0];
        fetch(imgSrc)
            .then(response => response.blob())
            .then(blob => {
                const file = new File([blob], "image.png", { type: "image/png" });
                const fileList = new DataTransfer();
                fileList.items.add(file);
                input3.files = fileList.files;

            });
    }





    function isNotSame($org, $test) {
        if ($org != $test) {
            return true;
        }
        return false;
    }





    // combo edit


    function un() {
        formData = new FormData()
        formData.append("transac", "unsetF")
        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {

            }, complete: function () {
            }
        });
    }

    function dumpProdIDs(comboID) {

        formData = new FormData()
        formData.append("transac", "dumpComboProd")
        formData.append("comboID", comboID)
        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {

            }, complete: function () {
            }
        });
    }

    function viewSelectedDumpedProd(id) {
        loadScCombo("sh")

        formData = new FormData()
        formData.append("transac", "viewSelectedDumpedProd")
        formData.append("comboID", parseInt(id))

        console.log(id);

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.data-products-selected').html(response);


            }, complete: function () {
                setTimeout(() => {
                    loadScCombo("rm")
                }, 500);
                $(".data-products-selected ol").addClass("new-data-products");
                if (runOnce == false) {
                    viewComboSumEdit();
                    runOnce = true
                }
            }
        });


    }

    function comboShowProdEdit(search) {
        loadScCombo("sh")

        formData = new FormData()
        formData.append("transac", "comboSectionShowSearchProdEdit")
        formData.append("name", search)



        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.data-products').html(response);

            }, complete: function () {
                setTimeout(() => {
                    loadScCombo("rm")
                }, 500);
                $(".data-products ol").addClass("new-data-products");

            }
        });
    }

    function deselectProdEdit(prodIDSel) {

        formData = new FormData()
        formData.append("productID", prodIDSel)
        formData.append("transac", "rmSelectedProdEdit")

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
                viewComboSumEdit();

            }
        });
    }

    function selectProdEdit(prodIDSel) {

        formData = new FormData()
        formData.append("productID", prodIDSel)
        formData.append("transac", "selectProdEdit")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.res === "error") {
                    console.log(lastitemEdit);

                    ab = `<ol class="new-data-products">${lastitemEdit}</ol>`
                    $(".data-products").append(ab);
                    $(ab).show()
                    $('.combo-response').html(response.msg);
                }
                $(".data-products .loadingScComboForm-outer").detach();

            }, complete: function () {
                viewComboSumEdit();

            }
        });


    }

    function viewComboSumEdit() {
        formData = new FormData()
        formData.append("transac", "viewComboSummaryEdit")

        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.data_summary_combo_edit').html(response);

            }
        });

    }





    // category edit

    function editCatSubmit(formData) {
        id = parseInt($("#editByID").parent().attr("id"))
        reqtype = $("#editcategory button").attr("value")

        formData.append("ID", id)
        formData.append("transac", "editCategory")
        formData.append("reqtype", reqtype)



        $.ajax({
            url: '../views/productView.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {

                $('.editcategory-response').html(response.msg);
                if (response.res !== "minorerr") {
                    if (response.res === "no error") {
                        $("#validateCat").html(`<i class="fas fa-plus"></i> Submit changes`)
                        $("#validateCat").attr(`value`, `update`)
                        $("#validateCat").attr(`id`, `submiteditCategory`)
                    } else if (response.res === "success") {
                        $("#editcategory input").val("");
                        $("#overlay_prod").hide();
                        prdShowState = 2
                        clearInterval(interval)
                        $(".editcategoryForm-outer").detach();
                        allCat("", 1)
                        notify(response.msg)
                    } else {
                        $("#submiteditCategory").html(`<i class="fas fa-check-square"></i> Validate`)
                        $("#submiteditCategory").attr(`value`, `check`)
                        $("#submiteditCategory").attr(`id`, `validateCat`)
                    }
                }

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


    function imagePick(dp, inpt, type = 1) {
        const profileImage = $(dp);
        const input = $(inpt)[0];
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function () {
                profileImage.attr('src', reader.result);
            };
            reader.readAsDataURL(file);

            if (type === 2) {
                $(".img-wrap-out > *").removeClass("emptyIP")
                $(".img-wrap-out > *").addClass("modifP")
            } else if (type === 3) {
                $(".picmeEdit").removeClass("emptyIP3")
                $(".picmeEdit").addClass("modifP3")
            }
        } else {
            profileImage.attr('src', '../image/dpTemplate.png');
            if (type === 2) {
                $(".img-wrap-out > *").removeClass("modifP")
                $(".img-wrap-out > *").addClass("emptyIP")
            } else if (type === 3) {
                $(".picmeEdit").removeClass("modifP3")
                $(".picmeEdit").addClass("emptyIP3")
            }
        }

    }
});
