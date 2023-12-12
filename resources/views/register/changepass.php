<?php require_once "regup.php"; ?>

<?php
    //Separar uri y obtener valor token    
    $uri = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    $tokenpass = explode("/",$uri);
?>

<div class="container box">        
    
        <form id="formChangePass" class="flexcol">
            <!----- csrf token ----->
            <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

            <h2 class="fontGrotesque center title">Crear nueva contraseña</h2>

            <div class="msg-field center" style="color: red;"></div>
            <div class="msg-notmatch center" style="color: red;"></div>
            <div class="msg-fail center" style="color: red;"></div>

            <input  type="hidden" name="tokenPass" value="<?= $tokenpass[2] ?>">
            
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" class="input">
            <div class="msg-pass1 center" style="color: red;"></div>
            
            <label for="passwordRepeat">Repite tu contraseña</label>
            <input type="password" name="passwordRepeat" id="passwordRepeat" class="input">
            <div class="msg-pass2 center" style="color: red;"></div>
            
            <input type="button" value="Guardar" class="btn btn-submit btn-chpass">

            <div class="loader-msg center"></div>

        </form>       
    </div>

<script src="/assets/js/changepass.js"></script>
<?php require_once "regdown.php"; ?>