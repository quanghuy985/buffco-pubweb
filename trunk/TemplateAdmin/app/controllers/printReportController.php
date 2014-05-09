<?php

class printReportController extends Controller {

    public function getHandle() {

        echo '<table>'
        . '<tr><th>Product ID</th><td>' . "test " . '</td></tr>'
        . '</table>';
    }

}
