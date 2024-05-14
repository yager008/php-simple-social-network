<?php
function debug_to_console($data) {
    // echo"debug_to_console function: <br>";
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    // echo "<br>";
    // echo "end of denug_to_console function<br>";
}
?>