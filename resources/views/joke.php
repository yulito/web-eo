<?php require_once "layout/template.up.php"; ?>

<div class="container-one-joke item-story box">
    <h2 class="center fontGrotesque"><?= $obj->title ?></h2>
    <div>
        <p class="content" id="textJoke"><?= $obj->publication ?></p>

        <!------AQUÍ VA UN ICONO PARA EL PLAY DE LA API-------->
        <p >
        <strong>-Reproducir:</strong>
            <span class="btn-play">                
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play" viewBox="0 0 16 16">
                <path d="M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
                </svg>
            </span>
        </p>
        <!-------------------------BTN---------------------------->
        <?php if(isset($_SESSION['auth']) && $_SESSION['auth']->id_rol == 4): ?>
            <?php 
                $user = $this->showLikeUser($obj->id_publication);
                $favUser = $this->showFavUser($obj->id_publication);              
            ?>

            <!-------------------------FAV---------------------------->
            <div>
            <span class="fav-span <?= $favUser ? 'fav-select' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                </svg>
            </span>
            <strong>Favoritos</strong>
            </div> 
            <!-------------------------LIKES---------------------------->
            <span class="heart-span  <?= $user ? 'heart-select' : '' ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                </svg>
            </span>            
        <?php endif; ?>

        <?php 
            $like = $this->showLikes($obj->id_publication); 
        ?>
        <strong>Likes: </strong><span class="like-span"><?= $like->sum_like ?></span>
        <input type="hidden" name="idpub" id="idPub" value="<?= $obj->id_publication ?>">             
        <br><hr>
    </div>
    <div class="info-joke">
        <div>
            <a href="/perfil/<?= $obj->name ?>">
                <?php if($obj->photo != '' || $obj->photo != null): ?>
                    <img src="/uploads/user/<?= $obj->photo ?>" style="height: 30px; width:30px; border-radius:50%;" alt="">
                <?php else: ?>
                    <img src="/assets/image/laugh.png" style="height: 30px; width:30px;" alt="">
                <?php endif; ?>
            </a>
        </div> 
        <div><strong>Fecha: </strong><span class="date"><?= date('d-m-Y',strtotime($obj->updated_at)) ?></span></div>  
        <div><strong>Usuario: </strong><span class="user"><?= $obj->name ?></span></div>
                
    </div> 
</div>

<script src="/assets/js/showJoke.js"></script>
<?php require_once "layout/template.down.php"; ?>