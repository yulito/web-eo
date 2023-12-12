<?php require_once "layout/template.up.php"; ?>

<div class=" flexcol box editbg"> 

    <h3 class="center" style="border-bottom: 1px solid #000;">Categoria -  
        <span style="color: rgb(85, 3, 85);">
            <?php if(isset($catObj)): ?>
                <strong><?= strtoupper($catObj['cat'] ) ?></strong>
            <?php else: ?>
                <strong><?= isset($msg) ? $msg : "ERROR INTERNO" ?></strong>
            <?php endif; ?>
        </span>
    </h3>

    <div class="box-list-cat flexcol">
        
            <?php if(isset($allObj) && $allObj != false):?>
            <?php foreach($allObj as $objs): ?>                
                <article class="cat-item-list box">
                    <a href="/chiste/<?= $objs['id_publication'] ?>/<?= $objs['name'] ?>">
                        <span><strong style="color: rgb(85, 3, 85);"><?= substr($objs['title'], 0, 16); ?>... </strong></span>
                        <span><strong><?=date('d-m-Y',strtotime($objs['updated_at']))?></strong></span>
                        <span><strong><?=$objs['name']?></strong></span> 
                    </a>
                </article>
                
            <?php endforeach; ?>
            <?php else: ?>
                    <h4 class="center">No hay nada agregado a esta categoria <span style="font-size: 44px;">&#128546;</span></h4>
            <?php endif; ?>            
        
    </div>

</div>



<?php require_once "layout/template.down.php"; ?>