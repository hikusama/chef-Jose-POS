<?php

// session_start();
// if (!isset($_SESSION['openPrint'])) {
//     header("Location: 404");
// }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../UX/jquery-3.5.1.min.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" href="../resources/style.css?v=<?php echo time();?>">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        @media print {
            @page {
                size: 3.15in auto;
            }
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="receipt">
        <div class="desc">
            <img src="../image/logo-receipt.png" id="receipt_logo" alt="">
            <h3>Chef Jose</h3>
            <p>Unit 5, Chef Jose, IGP Commercial HUB, WMSU Gate 1, Infront of R.T Lim Boulevard, Zamboanga City</p>
        </div>
        <div class="data-receipt">

        </div>
        <div class="th">Thank you for choosing us....</div>

    </div>

    <script>
        $(document).ready(function() {

            formData = new FormData()
            formData.append("transac", "print")

            $.ajax({
                url: '../Views/cashierView.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('.data-receipt').html(response);
                    window.print()
                },
                complete: function() {

                }
            });
            window.onafterprint = function() {
                window.close()

            }

        });
    </script>
</body>

</html>