<?php require_once "layout/template.up.php"; ?>

    <form id="formCreateAdmin" class="flexcol">
        <!----- csrf token ----->
        <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

        <h2 class="fontGrotesque center">Crear usuario administrador</h2>
        <p class="e-field center" style="color: red; font-weight: bold;"> </p>

        <label for="name">Nombre <span style="color: red;">*</span></label>
        <input type="text" name="name" id="name" class="input" >
        <p class="name-exist center" style="color: red; font-weight: bold;"> </p>
        
        <label for="email">Correo <span style="color: red;">*</span></label>
        <input type="email" name="email" id="email" class="input">
        <p class="e-email center" style="color: red; font-weight: bold;"> </p>
        <p class="email-exist center" style="color: red; font-weight: bold;"> </p>

        <label for="date">Fecha nacimiento <span style="color: red;">*</span></label>
        <input type="date" name="date" id="date" class="input">
        
        <label for="password">Contraseña <span style="color: red;">*</span>min:4, max:8</label>
        <input type="password" name="password" id="password" class="input">
        <p class="pass-len center" style="color: red; font-weight: bold;"></p>
        
        <input type="button" value="Crear" class="btn btn-submit btn-create-admin"> 
    </form>   

<script src="/assets/js/createAdmin.js"></script>
<?php require_once "layout/template.down.php"; ?>