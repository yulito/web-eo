<?php require_once "layout/template.up.php"; ?>

<h2 class="center" style="border-bottom: 1px solid #000;">FAVORITOS </h2>
<?php if(isset($msg)):?>
    <h2 class="center"><strong ><?= $msg ?></strong></h2>
<?php endif; ?>

    <div class="box-table">
            <table>
                <thead>
                    <tr>
                        <th><strong>Nro</strong></th>
                        <th>Chiste</th>                        
                        <th>Fecha</th> 
                        <th>Usuario</th>                                               
                        <th>Ver</th>
                    </tr>
                </thead>            
                <!--------- ACA MOSTRAMOS LA LISTA DE FAVORITOS------------>            
                <tbody>
                <?php if(isset($obj)): ?>
                    <?php
                    $nro = 1; 
                    foreach($obj as $obj): 
                    ?>
                    <tr>
                        <td><?= $nro ?></td>
                        <td><?= substr($obj['title'], 0, 20); ?>...</td>
                        <td><?= date('d-m-Y',strtotime($obj['updated_at'])) ?></td>                        
                        <td><?= $obj['name']?></td>                        
                        <td class="cel-color-see">
                            <a href="/chiste/<?= $obj['id_publication'] ?>/<?= $obj['name'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <?php
                    $nro++;
                    endforeach; 
                    ?>   
                <?php endif; ?>
                </tbody>                         
            </table>
        </div> 
        
<script src="#"></script>
<?php require_once "layout/template.down.php"; ?>