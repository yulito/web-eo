<?php require_once "regup.php"; ?>

    <div class="container box">
        
        <form class="flexcol" id="form-reg" >
            <!----- csrf token ----->
            <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

            <h2 class="fontGrotesque center title">Formulario de registro</h2>
            <p class="e-field center" style="color: red; font-weight: bold;"> </p>

            <label for="">Nombre o alias <span style="color: red;">*</span></label>
            <input type="text" name="name" id="name" class="input">
            <p class="name-exist center" style="color: red; font-weight: bold;"> </p>
            
            <label for="">Correo <span style="color: red;">*</span></label>
            <input type="email" name="email" id="email" class="input" placeholder="example@example.com">
            <p class="e-email center" style="color: red; font-weight: bold;"> </p>
            <p class="email-exist center" style="color: red; font-weight: bold;"> </p>

            <label for="">Fecha nacimiento <span style="color: red;">*</span></label>
            <input type="date" name="date" id="date" class="input" >

            <label for="">Foto perfil</label>
            <input type="file" name="photo" id="photo" class="input" >
            
            <label for="">Contraseña <span style="color: red;">* </span>(min:4, max:8 caracteres)</label>
            <input type="password" name="password" id="password" class="input">
            <p class="e-pass center" style="color: red; font-weight: bold;"> </p>
            
            <input type="button" value="Enviar" class="btn btn-submit btn-reg">
            <div class="loader-msg center"></div>
        </form>   

    </div>


<script src="/assets/js/registrojs.js"></script>
<?php require_once "regdown.php"; ?>