<?php
    require_once('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Listado de clientes</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Legajo</th>
                         <th>Apellido</th>
                         <th>Nombre</th>
                    </thead>
                    <tbody>
                         <?php
                              foreach($keeperList as $keeper)
                              {
                                   ?>
                                        <tr>
                                             <td><?php echo $keeper->getID() ?></td>
                                             <td><?php echo $keeper->getNombreUser() ?></td>
                                             <td><?php echo $keeper->getContrasena() ?></td>
                                             <td><?php echo $keeper->getTipo() ?></td>
                                             <td><?php echo $keeper->getRemuneracion() ?></td>
                                        </tr>
                                   <?php
                              }
                         ?>
                         </tr>
                    </tbody>
               </table>
          </div>
     </section>
</main>