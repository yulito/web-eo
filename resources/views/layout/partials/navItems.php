<nav>
    <ul>
        <li>
            <select name="cat" id="cat" class="nav-slct">
                <option selected disabled class="fontGrotesque">Categorias</option>

                <?php $catAll = $this->showCategories(); ?>
                <?php while($cat = $catAll->fetch_object()): ?>                    
                    <option value="/categoria/<?=$cat->id_cat ?>">
                        <?= $cat->cat ?>
                    </option>                    
                <?php endwhile; ?>

            </select>
        </li>

        <?php if(isset($_SESSION['auth'])): ?>
            
            <li ><a href="/editar-perfil" >

                <?php if($_SESSION['auth']->photo != null || $_SESSION['auth']->photo != ''): ?>
                    
                    <img src="/uploads/user/<?= $_SESSION['auth']->photo ?>" style="height: 30px; width:30px; border-radius:50%;" alt="">                            

                <?php else :?>
                    <img src="/assets/image/laugh.png" style="height: 30px; width:30px;" alt="">
                    
                <?php endif; ?>

            </a></li>
        <?php endif; ?>

            <li><a href="/acerca">Acerca de</a></li>
    </ul>
</nav>
