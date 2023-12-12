<?php require_once "layout/template.up.php"; ?>

    <div class="main-content last-stories flexcol">                       
        <h2 class="center contitle">Últimas publicaciones</h2>
    </div>

    <!---------------- TEMPLATE --------------->
    <template id="tmp-list">
        <a href="">
            <div class="stories box">
                <h2 class="center fontGrotesque"></h2>
                <p class="content"></p>
                <p class="info">
                    <strong>Fecha: </strong><span class="date"></span>    |   <strong>Usuario: </strong><span class="user"></span>                                     
                </p>
            </div>
        </a> 
    </template>

<script src="/assets/js/listHome.js"></script>
<?php require_once "layout/template.down.php"; ?>