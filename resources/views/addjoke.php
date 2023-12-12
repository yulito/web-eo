<?php require_once "layout/template.up.php"; ?>

<div class="flexcol box jokebg">
    <form id="formPublication" class="flexcol">
        <!----- csrf token ----->
        <input  type="hidden" name="token_" value="<?php echo $this->createTokenCsrf(); ?>">

        <h2 class="fontGrotesque center">Crear Chiste</h2>
        <p class="e-field center" style="color: red; font-weight: bold;"> </p>
        <p class="e-error center" style="color: red; font-weight: bold;"> </p> 

        <label for="title">Titulo</label>
        <input type="text" name="title" id="title" class="input">                    
        
        <label for="publication">Publicación</label>
        <textarea name="publication" id="publication" >...</textarea>
        
        <select name="state" id="state" class="input">
            <option selected disabled>Estado</option>
                <?php $states = $this->showState(); ?>
                <?php while($st = $states->fetch_object()): ?>
                    <option value=<?=$st->id_state ?>>
                        <?= $st->state ?>
                    </option>
                <?php endwhile; ?>
        </select>

        <select name="cat" id="cat" class="input">
            <option selected disabled>Categoria</option>
                <?php $catAll = $this->showCategories(); ?>
                <?php while($cat = $catAll->fetch_object()): ?>
                    <option value=<?=$cat->id_cat ?>>
                        <?= $cat->cat ?>
                    </option>
                <?php endwhile; ?>            
        </select>
        
        <input type="button" value="Guardar" class="btn btn-submit btn-form-joke"> 
    </form>   
</div>

<script src="/assets/js/createJoke.js"></script>
<?php require_once "layout/template.down.php"; ?>