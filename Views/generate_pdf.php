<?php
require 'libfunc/vendor/autoload.php';

use Dompdf\Dompdf;

if (isset($_POST['html'])) {
    $html = $_POST['html']; 

    $dompdf = new Dompdf();

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="converted.pdf"');
    echo $dompdf->output();
} else {
    echo "No HTML content received.";
}
?>
