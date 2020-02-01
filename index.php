<?php
require_once ('libs/app.php');
require_once ('views/helpers.php');
require_once ('plantilla/header.php');
require_once ('plantilla/nav.php');
?>

<div id="container" class="d-flex flex-row col-lg-12 col-md-12 col-sm-12 justify-content-center">
    <?php
    const DEFAULT_PAGE = 'views/main.php';
    require_once ('plantilla/leftmenu.php');
    
    
    if(isset($_GET['menu'])){
        $page = new app($_GET['menu']);
        $page->render();
    }else{
        require_once(DEFAULT_PAGE);
    }
    
    require_once ('plantilla/rightmenu.php');
    ?>
</div>

<?php
require_once ('plantilla/footer.php');
?>