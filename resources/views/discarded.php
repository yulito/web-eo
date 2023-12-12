<?php require_once "layout/template.up.php"; ?>

<div style="padding: 2%;">
    <h2 class="center">Papelera</h2>
    <div class="flexcol box editbg">
    <div class="box-table">
            <table>
                <thead>
                    <tr>
                        <th><strong>Nro</strong></th>
                        <th>Chiste</th>
                        <th>Fecha</th>                        
                        <th>Estado</th>
                        <th>Restaurar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>            
                <!--------- ACA MOSTRAMOS LA LISTA DE CHISTES DEL USUARIO ------------>            
                <tbody>
                    <?php if(isset($obj)): ?>
                    <?php
                    $nro = 1; 
                    foreach($obj as $obj): 
                    ?>
                    <tr>
                        <td><?= $nro ?></td>
                        <td><?= substr($obj['title'], 0, 20); ?>...</td>
                        <td><?=  date('d-m-Y',strtotime($obj['updated_at'])) ?></td>
                        <td><?= $obj['state'] ?></td>
                    
                        <td class="cel-color-see">
                            <a href="/restaurar/<?= $obj['id_publication'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-recycle" viewBox="0 0 16 16">
                                <path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/>
                                </svg>
                            </a>
                        </td>

                        <td class="cel-color-delete" >
                            <a href="/eliminar-chiste/<?= $obj['id_publication'] ?>">                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-x" viewBox="0 0 16 16">
                                <path d="M6.146 6.146a.5.5 0 0 1 .708 0L8 7.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 8l1.147 1.146a.5.5 0 0 1-.708.708L8 8.707 6.854 9.854a.5.5 0 0 1-.708-.708L7.293 8 6.146 6.854a.5.5 0 0 1 0-.708z"/>
                                <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
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
    </div>  
</div>

<?php require_once "layout/template.down.php"; ?>