<?php require_once "regup.php"; ?>

<div class="container box">    
        <form id="recoveryForm" class="flexcol">
            <!----- csrf token ----->
            <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

            <h2 class="fontGrotesque center title">Enviar correo de solicitud de cambio de contraseña</h2>
            
            <label for="email">Correo</label>
            <input type="email" name="email" id="email" class="input" placeholder="ejemplo@ejemplo">
            <div class="msg-rec center"></div> 
            
            <input type="button" value="Enviar" class="btn btn-submit  btn-rec">
            <div class="loader-msg center"></div>

        </form>       
    </div>


<script src="/assets/js/recovery.js"></script>
<?php require_once "regdown.php"; ?>