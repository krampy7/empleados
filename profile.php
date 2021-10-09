<?php
//Se incluye la conexion a la base de datos
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Datos de empleado</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style_nav.css" rel="stylesheet">
	<link href="media/dolphin.png" rel="shortcut icon">
	<style>
		.content {
			margin-top: 80px;
		}
	</style>
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<!-- Se incluye la barra de navegacion a partir de php -->  
	<nav class="navbar navbar-default navbar-fixed-top">
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Datos del empleado</h2>
			<hr />
			
			<?php
			// Se obtiene el ID eliminando cualquier apartado de HTML o JS
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			
			//Se seleccionan todos los elementos en la base de datos con el id que sea identico a la variable $nik
			$sql = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
			//Si no hay filas en la query (consulta) significa que no hay datos
			if(mysqli_num_rows($sql) == 0){
				//Se redirecciona al home de la pagina
				header("Location: index.php");
			}else{
				//Si no es asi, por lo tanto se encontraron los datos y se almacenan en la variable row
				$row = mysqli_fetch_assoc($sql);
			}
			?>
			<!-- Se muestran todos los datos en una tabla a partir de la variable row la cual posee todos los datos -->
			<table class="table table-striped table-condensed">
				<tr>
					<th width="20%">ID</th>
					<td><?php echo $row['codigo']; ?></td>
				</tr>
				<tr>
					<th>Nombre del empleado</th>
					<td><?php echo $row['nombres']; ?></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><?php echo $row['direccion']; ?></td>
				</tr>
				<tr>
					<th>Teléfono</th>
					<td><?php echo $row['telefono']; ?></td>
				</tr>
				<tr>
					<th>Estado</th>
					<td>
						<?php 
							if ($row['estado']==1) {
								echo "Activo";
							} else if ($row['estado']==2){
								echo "Suspendido";
							} else if ($row['estado']==3){
								echo "Inactivo";
							}
						?>
					</td>
				</tr>
			</table>
			
			<!-- Link para regresar al menu -->
			<a href="index.php" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Regresar</a>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>