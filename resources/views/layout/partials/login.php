<p class="e-auth_error" style="color: red;"></p>
<p class="e-field" style="color: red;"></p>

<form id="formLogin" class="flexcol">
        <!----- csrf token ----->
        <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

        <h2 class="fontGrotesque">Ingresar</h2>
        
        <label for="email">Correo</label>
        <input type="email" name="email" id="email" class="input" placeholder="ejemplo@ejemplo.com">
        <p class="e-email" style="color: red;"></p>
        
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" class="input">
        
        <input type="button" value="Entrar" class="btn-login btn btn-submit">
</form> 
<div class="center">
        <span>Pincha el link para registrarte.</span><a href="/registrar" class="link">Regístrate</a>
</div>
<div class="center">
        <span>Olvidaste tu contraseña?. Pincha el siguiente link -></span><a href="/recuperar" class="link">Recuperar contraseña</a>
</div> 