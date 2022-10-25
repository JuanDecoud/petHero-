<?php
use DAO\KeeperDAO;

$keeperdao = new KeeperDAO ();
$listaKeepers = $keeperdao->getAll();
$listaEstadias = $keeperdao->listaEstadias($listaKeepers);
?>

<?php foreach ($listaEstadias as $estadias){ ?>

<div class="card-body">
    <form action="">
        <table class ="table-sm   ">
            <thead>
                <tr>
                    <th scope ="col p-2">Desde:</th>
                    <th>
                        <input value ="<?php echo $estadias->getDesde(); ?>" style =" text-align: center; font-weight:bold; color:black; border:0; " class ="col-8 border-dark border-bottom" type="text" placeholder="<?php echo $estadias->getDesde(); ?>" name ="desde"  readonly >
                    </th>
                </tr>
            </thead>
            <tbody>
                <th scope ="col p-2">
                    Hasta:
                </th>
                <td>
                    <input value =""style =" text-align: center; font-weight:bold; color:black; border:0;" type="text" placeholder="" name ="hasta"  value = ""readonly  class = "col-8  border-bottom border-dark">
                </td> 
            </tbody>
        </table>
         <table class = "mt-4">
            <thead>
                 <tr scope = "col ">
                    <td>
                        <button type="submit" class=" btn btn-danger btn-sm  ">Reservar</button>
                    </td>
                </tr>
             </thead>
        </table>  
     </form>
<?php }?>
                            </div>
                                    
                                
                            </div>     
                        </div>
                    </div>
                    </div>
                </div>
        </div>
</div>
