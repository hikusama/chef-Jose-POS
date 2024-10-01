<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body{
            font-size: 20px;
        }
        *{
            margin: 0;
            padding: 0;
        }
        
        @media print{
            @page {
                size: 3.15in auto;
            }
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="receipt">

        <div class="receipt-header">Chef Jose</div>
        <div class="receipt-item">
            <span>Item 1</span>
            <span>$10.00</span>
        </div>
        <div class="receipt-item">
            <span>Item 1</span>
            <span>$10.00</span>
        </div>
        <div class="receipt-total">Total: $20.00</div>
    </div>

    <script>
        window.print()
    </script>
</body>
</html>