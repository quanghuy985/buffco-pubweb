<?php
$presenter = new Illuminate\Pagination\BootstrapPresenter($paginator);
?>

<?php if ($paginator->getLastPage() > 1): ?>
    <div class="pagination">
        <ul>
            <?php
            /* How many pages need to be shown before and after the current page */
            $showBeforeAndAfter = 5;

            /* Current Page */
            $currentPage = $paginator->getCurrentPage();
            $lastPage = $paginator->getLastPage();
            $start = 0;
            if ($currentPage - $showBeforeAndAfter < -1) {
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
            if ($lastPage > $showBeforeAndAfter and $currentPage != 1 and $currentPage > 3) {
                ?>
                <li><a href="<?php echo $presenter->getUrlPage(1); ?>">Last</a></li>
                <?php
            }
            if ($lastPage > $showBeforeAndAfter and $currentPage != 1) {
                echo $presenter->getPrevious('<<');
            }
            if ($lastPage != 1) {
                echo $presenter->getPageRange($start, $end);
            }
            if ($lastPage > $showBeforeAndAfter and $currentPage != $lastPage) {
                echo $presenter->getNext('>>');
            }
            if ($lastPage > $showBeforeAndAfter and $currentPage != $lastPage and $lastPage - $currentPage > 2) {
                ?>
                <li><a href="<?php echo $presenter->getUrlPage($lastPage); ?>">Last</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
<?php endif; ?>