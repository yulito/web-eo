<?php require_once "layout/template.up.php"; ?>

<div class="flexcol box jokebg">
    <form id="formEditJoke" class="flexcol">
        <!----- csrf token ----->
        <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

        <h2 class="fontGrotesque center">Editar Chiste</h2>
        <p class="e-field center" style="color: red; font-weight: bold;"> </p>
        <p class="e-error center" style="color: red; font-weight: bold;"> </p> 

        <label for="title">Titulo</label>
        <input type="hidden" name="idPub" id="idPub" class="input" value="<?= $obj->id_publication ?>">
        <input type="text" name="title" id="title" class="input" value="<?= $obj->title ?>">                    
        
        <label for="publication">Publicación</label>
        <textarea name="publication" id="publication" ><?= $obj->publication ?></textarea>
        
        <select name="state" id="state" class="input">
            <option selected value="<?= $obj->id_state ?>"><?= $obj->state ?></option>
                <?php $states = $this->showState(); ?>
                <?php while($st = $states->fetch_object()): ?>
                    <option value=<?=$st->id_state ?>>
                        <?= $st->state ?>
                    </option>
                <?php endwhile; ?>
        </select>

        <select name="cat" id="cat" class="input">
            <option selected value="<?= $obj->id_cat ?>"><?= $obj->cat ?></option>
                <?php $catAll = $this->showCategories(); ?>
                <?php while($cat = $catAll->fetch_object()): ?>
                    <option value=<?=$cat->id_cat ?>>
                        <?= $cat->cat ?>
                    </option>
                <?php endwhile; ?>            
        </select>
        
        <input type="button" value="Editar" class="btn btn-submit btn-edit-joke"> 
    </form>   
</div>

<script src="/assets/js/editJoke.js"></script>
<?php require_once "layout/template.down.php"; ?>