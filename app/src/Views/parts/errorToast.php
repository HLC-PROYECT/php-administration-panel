<?php
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    if (is_array($error)) {
        foreach ($error as $value) {
            echo $value;
            echo '<script type="text/javascript">',
                'showError("' . $value . '");',
            '</script>';
        }
    } else {
        echo '<script type="text/javascript">',
            'showError("' . $error . '");',
        '</script>';
    }

    unset($_SESSION['error']);
    session_write_close();
}
?>