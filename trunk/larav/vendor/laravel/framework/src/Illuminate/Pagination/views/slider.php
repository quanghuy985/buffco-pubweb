<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <ul class="pagination pagination-lg pull-left">
        <?php
        /* How many pages need to be shown before and after the current page */
        $showBeforeAndAfter = 5;

        /* Current Page */
        $currentPage = $paginator->getCurrentPage();
        $lastPage = $paginator->getLastPage();
        $start = 0;
        if ($currentPage - $showBeforeAndAfter < -1 || $lastPage < $showBeforeAndAfter) {
            $start = 1;
            if ($lastPage < $showBeforeAndAfter) {
                $end = $lastPage;
            } else {
                $end = 5;
            }
        } else {
            if ($lastPage - $currentPage > 2) {
                $start = $currentPage - 2;
                $end = $currentPage + 2;
            } else {
                $start = $lastPage - 5;
                $end = $lastPage;
            }
        }
        if ($currentPage != 1) {
            ?>
            <li><a  style="font-size: 18px;" href="javascript: void(0)" onclick="phantrang(<?php echo $currentPage - 1; ?>)">‹</a></li>
            <?php
        } else {
            ?>
            <li><a class="disable"  style="font-size: 18px;" href="javascript: void(0)">‹</a></li>
            <?php
        }
        if ($lastPage != 1) {
            for ($i = $start; $i <= $end; $i++) {
                if ($i != $currentPage) {
                    ?>
                    <li><a  href="javascript: void(0)" onclick="phantrang(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
                    <?php
                } else {
                    ?>
                    <li class="active"><span><?php echo $i; ?></span></li>
                    <?php
                }
            }
            //  echo $presenter->getPageRange($start, $end);
        }
        if ($currentPage != $lastPage) {
            ?>
            <li><a  style="font-size: 18px;" href="javascript: void(0)" onclick="phantrang(<?php echo $currentPage + 1; ?>)">›</a></li>
            <?php
        } else {
            ?>
            <li><a class="disable"  style = "font-size: 18px;" href = "javascript: void(0)">›</a></li>
                <?php
            }
            ?>
    </ul>
<?php endif; ?>