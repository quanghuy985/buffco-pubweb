<?php

namespace BackEnd;

class printReportController extends \BaseController {

    public function getHandle() {

        echo '<table>'
        . '<tr><th>Product ID</th><td>' . "test " . '</td></tr>'
        . '</table>';
    }

}
