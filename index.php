<?php
//Conexión a la base de datos incluida
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos</title>
	<link href="media/dolphin.png" rel="shortcut icon">

	<!-- Bootstrap instalado-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">

	<!-- Estilo basico -->
	<style>
		.content {
			margin-top: 80px;
		}
		.label-wow{
			background-color: #B22222;
		}
		img{
			margin-right: 5px;
		}
	</style>

</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include('nav.php');?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Empleados...</h2>
			<hr />

			<?php
			//Si el valor aksi es igual a delete por lo tanto...
			if(isset($_GET['aksi']) == 'delete'){
				//Se remueve todo lo que puea haber dentro, ya sea HTML o JS
				//La varibale $con se obtuvo de conexion.php, esta es la conexión a la base de datos
				$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
				/**Se realiza una query con la base de datos, se seleccionan todos los empleados y sus datos, siempre y cuando el id que se obtuvo 
				 * por el get sea igual que en la base de datos**/
				$cek = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
				//Si no se encontro ninguna fila que coincida con el id, el empleado no se encontro y se muestra un error
				if(mysqli_num_rows($cek) == 0){
					echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> No se encontraron datos.</div>';
				}
				//Si no es asi, por lo tanto si se encontro el usaurio
				else{
					//Se borra la fila con el id encontrado anteriormente
					$delete = mysqli_query($con, "DELETE FROM empleados WHERE codigo='$nik'");
					//Si es que se elimino, se mostrara en pantalla de manera correcta
					if($delete){
						echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Datos eliminado correctamente.</div>';
					}
					//Si no se pudo realizar la query, se mostrara un error en pantalla
					else{
						echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Error, no se pudo eliminar los datos.</div>';
					}
				}
			}
			?>

			<form class="form-inline" method="get">
				<div class="form-group">
					<!-- Se llamara a la funcion sumbit cada vez que exista un cambio -->
					<!-- Se crea un selector para tener 3 opciones de estados para visualizar los empleados -->
					<select name="filter" class="form-control" onchange="form.submit()">
						<option value="0">Filtro de empleados</option>
						<?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
						<option value="1">Activo</option>
						<option value="2">Suspendido</option>
                        <option value="3">Inactivo</option>
					</select>
				</div>
			</form>
			<br />
			<div class="table-responsive">
				<!-- Se crea la tabla junto con sus cabeceras correspondientes-->
			<table class="table table-striped table-hover">
				<tr>
                    <th>ID</th>
					<th>Nombre</th>
                    <th>Email</th>
					<th>Teléfono</th>
					<th>Estado</th>
                    <th>Acciones</th>
				</tr>
				<?php
				//Si se llego a seleccionar un filtro
				if($filter){
					$sql = mysqli_query($con, "SELECT * FROM empleados WHERE estado='$filter' ORDER BY codigo ASC");
				}
				//De lo contrario, se seleccionan todos los campos de la tabla empleados y se almacena el query en una variable
				else{
					$sql = mysqli_query($con, "SELECT * FROM empleados ORDER BY codigo ASC");
				}
				//Si la cantidad de datos es 0, por lo tanto se desplegara que no hay usaurios
				if(mysqli_num_rows($sql) == 0){
					echo '<tr><td colspan="8">No hay datos.</td></tr>';
				}else{
					//Se crea un loop el cual se repetira la las veces que exista una fila de datos
					//Se despliegan todos los datos dentro de la tabla
					while($row = mysqli_fetch_assoc($sql)){
						echo '
						<tr>
							<td>'.$row['codigo'].'</td>
							<td><a href="profile.php?nik='.$row['codigo'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> '.$row['nombres'].'</a></td>
                            <td>'.$row['direccion'].'</td>
							<td>'.$row['telefono'].'</td>
							<td>';
							if($row['estado'] == '1'){
								echo '<span class="label label-success">Activo</span>';
							}
                            else if ($row['estado'] == '2' ){
								echo '<span class="label label-warning">Suspendido</span>';
							}
                            else if ($row['estado'] == '3' ){
								echo '<span class="label label-wow">Inactivo</span>';
							}
						echo '
							</td>
							<td>
								<a href="edit.php?nik='.$row['codigo'].'" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
								<a href="index.php?aksi=delete&nik='.$row['codigo'].'" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos '.$row['nombres'].'?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
							</td>
						</tr>
						';
					}
				}
				?>
			</table>
			</div>
		</div>
	</div><center>
	<p>&copy; Roberto Adrian Cano Rodriguez | <?php echo date("Y");?></p
		</center>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
