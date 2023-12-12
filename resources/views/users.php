<?php require_once "layout/template.up.php"; ?>

<h2 class="center" style="border-bottom: 1px solid #000;">Lista de usuario registrados</h2>
<?php if(isset($msg)): ?>
<h4 class="center"><strong style="color: red;"><?=$msg?></strong></h4>
<?php endif;?>

<div class="box-table">
            <table>
                <thead>
                    <tr>
                        <th><strong>Nro</strong></th>
                        <th>Usuario</th>                        
                        <th>Fecha registro</th> 
                        <th>Correo</th>
                        <th>Rol</th>                                        
                        <th>Ver perfil</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>            
                <!--------- ACA MOSTRAMOS LA LISTA DE USUARIOS------------>            
                <tbody>
                <?php if(isset($obj)): ?>
                    <?php
                    $nro = 1; 
                    foreach($obj as $obj): 
                    ?>
                    <tr>
                        <td><?= $nro ?></td>
                        <td><?= $obj['name']; ?>...</td>
                        <td><?= date('d-m-Y',strtotime($obj['created_at'])) ?></td>                        
                        <td><?= $obj['email']?></td>   
                        <td><?= $obj['id_rol'] == 3 ? 'Admin' : 'Usuario'; ?></td>

                        <td class="cel-color-see">
                            <a href="/perfil/<?= $obj['name'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>
                            </a>
                        </td>
                        <td class="cel-color-delete" >
                                <a href="/eliminar-usuario/<?= $obj['id_user'] ?>">                                
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
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