<?php require_once "layout/template.up.php"; ?>

    <div style="padding: 2%;">

        <div class="flexcol box editbg">

                <?php if($_SESSION['auth']->photo != null || $_SESSION['auth']->photo != ''): ?>
                    
                    <img src="/uploads/user/<?= $_SESSION['auth']->photo ?>" style="height: 140px; width:140px; border-radius:50%;" alt="">                            

                <?php else :?>
                    <img src="/assets/image/laugh.png" style="height: 140px; width:140px;" alt="">
                    
                <?php endif; ?>
            
            <form id="formEditProfile" class="flexcol">
                <!----- csrf token ----->
                <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

                <h2 class="fontGrotesque center">Editar perfil</h2>
                <p class="e-field center" style="color: red; font-weight: bold;"> </p>

                <label for="name">Nombre o alias</label>
                <input type="text" name="name" id="name" class="input" value="<?= $_SESSION['auth']->name ?>">
                <p class="name-exist center" style="color: red; font-weight: bold;"> </p>
                
                <label for="email">Correo</label>
                <input type="email" name="email" id="email" class="input" value="<?= $_SESSION['auth']->email ?>" >
                <p class="e-email center" style="color: red; font-weight: bold;"> </p>
                <p class="email-exist center" style="color: red; font-weight: bold;"> </p>

                <label for="date">Fecha nacimiento</label>
                <input type="date" name="date" id="date" class="input" value="<?= $_SESSION['auth']->birth_date ?>" >

                <label for="photo">Foto perfil</label>
                <input type="file" name="photo" id="photo" class="input"  >         
                
                <input type="button" value="Editar" class="btn btn-submit btn-edit-profile"> 
            </form>   

            <!----------Cambio de contraseña----------->

            <form id="formEditPass" class="flexcol">
                <h2 class="fontGrotesque center">Cambiar contraseña</h2>
                <p class="pass-error center" style="color: red; font-weight: bold;"> </p>

                <label for="password">Nueva contraseña <span style="color: red;">* </span>(min:4, max:8 caracteres)</label>
                <input type="password" name="password" id="password" class="input">
                <p class="pass-empty center" style="color: red; font-weight: bold;"> </p>
                <p class="pass-len center" style="color: red; font-weight: bold;"> </p>

                <input type="button" value="Guardar cambios" class="btn btn-submit btn-edit-pass"> 
            </form>

            <!---------Eliminar cuenta----------------->
    
            <strong class="a-item" style="color:red;">
                Eliminar cuenta de manera permanente
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-x" viewBox="0 0 16 16">
                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm.256 7a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256Z"/>
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                </svg>
            </strong>
            <button class="btn btn-delete btn-delete-profile" style="margin-bottom:20px">
                <a href="/eliminar-usuario/<?= $_SESSION['auth']->id_user ?>"> Eliminar Cuenta </a>
            </button>

        </div>

    </div>
    
<script src="/assets/js/editUser.js"></script>
<?php require_once "layout/template.down.php"; ?>