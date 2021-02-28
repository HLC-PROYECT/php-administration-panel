<?php
foreach ($this->errors as $value) {
    echo $value;
    echo '<script type="text/javascript">',
        'showError("' . $value . '");',
    '</script>';
}
?>