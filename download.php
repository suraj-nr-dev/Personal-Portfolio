<?php
$file = 'assets/images/SURAJ_N_RESUME.pdf'; // Change the filename as needed

if (file_exists($file)) {
    // Send headers to initiate file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "File not found.";
}
?>
    