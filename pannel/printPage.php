<?php

session_start();
if (!isset($_SESSION['openPrint'])) {
    header("Location: 404.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time(); ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        #ov {
            display: none;
            height: 100vh;
            position: absolute;
            width: 100%;
            background: #00000073;
            z-index: 1;
        }

        .prmp {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            background: white;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 25rem;
            height: 16rem;
            border-radius: .8rem;
            place-items: center;
        }
        .receipt{
            padding-bottom: 2.4rem;

        }

        #done {
            padding: 1rem 3rem;
        }

        @media print {
            @page {
                size: 58mm auto;
                margin: 0;
            }
        }
    </style>
    <title>Document</title>
</head>

<body>
    <!-- <div id="ov"></div> -->
    <div class="receipt">
        <div class="desc">
            <img src="../image/logo-receipt.png" id="receipt_logo" alt="">
            <h3>Chef Jose</h3>
            <p>Unit 5, Chef Jose, IGP Commercial HUB, WMSU Gate 1, Infront of R.T Lim Boulevard, Zamboanga City</p>
        </div>
        <div class="data-receipt">

        </div>
        <div class="th">Thank you for choosing us....</div>
        <p style="
    text-align: center;
">*****************************************</p>    </div>
    <!-- <div class="prmp">
        <button id="done">Next order</button>
    </div> -->

    <script>
        $(document).ready(function() {

            formData = new FormData()
            formData.append("transac", "print")

            let done = 0;
            $.ajax({
                url: '../Views/cashierView.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.data-receipt').html(response);
                    window.print()
                    // setTimeout(() => {

                    //     $("#ov").show();
                    //     $(".prmp").css("display", "grid");
                    // }, 2000);
                },
                complete: function() {}
            });

            $("#done").click(function(e) {
                e.preventDefault();
                window.close()

            });
            // inter = setInterval(() => {
            //     if (done != 0) {   
            //         window.onafterprint = function() {
            //             window.close()
            //         }
            //         clearInterval(inter);
            //     }else{

            //     }
            // }, 1000);

        });
    </script>
</body>

</html>