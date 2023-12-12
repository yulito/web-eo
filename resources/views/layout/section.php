<!----------- ASIDE ------------->
<aside class="box">

<div class="container flexcol box-login center">

    <?php if(!isset($_SESSION['auth'])): ?>

        <?php 
            //form login
            require_once "partials/login.php"; 
        ?>
    
    <?php else :?>
        
        <?php 
            //menu perfil
            require_once "partials/menu.php"; 
        ?> 
        
    <?php endif; ?>        

</div>

</aside>    