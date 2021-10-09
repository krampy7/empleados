<?php
//Se realiza de nuevo la conexion a la base de datos
include("conexion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Editar datos</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-datepicker.css" rel="stylesheet">
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
	<nav class="navbar navbar-default navbar-fixed-top">
		<!-- Se incluye la barra de navegacion-->
		<?php include("nav.php");?>
	</nav>
	<div class="container">
		<div class="content">
			<h2>Editar datos</h2>
			<hr />
			
			<?php
			// Se elimina todo el contendo HTML y JS
			//Se obtiene el nik o id de usaurio por el metodo get que se envio con anterioridad desde index.php
			$nik = mysqli_real_escape_string($con,(strip_tags($_GET["nik"],ENT_QUOTES)));
			//Se realiza una query seleccionando todos los datos con ese id
			$sql = mysqli_query($con, "SELECT * FROM empleados WHERE codigo='$nik'");
			//Si es que el total de filas es igual a 0
			if(mysqli_num_rows($sql) == 0){
				//Se manda al index debido a que no hay empleados que posean ese ID 
				header("Location: index.php");
			}else{
				//Lo datos de la query se almacenan en la variable row
				$row = mysqli_fetch_assoc($sql);
			}
			//Si es que el usaurio dio a guardar la informacion...
			//Se colocan todas las modificaciones del formulario en variables
			if(isset($_POST['save'])){
				//Se almacena el dato por un metodo POST y se almacena en la nueva variable para ser actualizada
				$codigo		     = mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));//Escanpando caracteres 
				$nombres		 = mysqli_real_escape_string($con,(strip_tags($_POST["nombres"],ENT_QUOTES)));//Escanpando caracteres 
				$direccion	     = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));//Escanpando caracteres 
				$telefono		 = mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));//Escanpando caracteres 
				$estado			 = mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));//Escanpando caracteres  
				
				//Se realiza una query em la cual se aplica un UPDATE en la base de datos, y se asignan los datos de las varibales anteriormente asignadas a los campos
				$update = mysqli_query($con, "UPDATE empleados SET nombres='$nombres', direccion='$direccion', telefono='$telefono', estado='$estado' WHERE codigo='$nik'") or die(mysqli_error());
				//Si es que la query se llevo a cabo
				if($update){
					//Se actualiza la pagina y se manda el id del usaurio junto con la variable pesan la cual se le asigno el valor sukses
					header("Location: edit.php?nik=".$nik."&pesan=sukses");	
				}
				//No se pudo llevar a cabo la query y se le informa al usuario que no pudo ser actualizado
				else{
					echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error, no se pudo guardar los datos.</div>';
				}
			}
			//Si el usaurio ya edito sus datos, la varible pesan valdra sukses
			if(isset($_GET['pesan']) == 'sukses'){
				//Se le informa al usaurio que se relizo con exito la actualizacion de los datos
				echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Los datos han sido guardados con éxito.</div>';
			}
			?>
			<!-- Es un forma el cual recibira los datos para ser actualizados, esto a partir del metodo post -->
			<form class="form-horizontal" action="" method="post">
				<div class="form-group">
					<label class="col-sm-3 control-label">ID</label>
					<div class="col-sm-2">
						<input type="text" name="codigo" value="<?php echo $row ['codigo']; ?>" class="form-control" placeholder="ID" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Nombres</label>
					<div class="col-sm-4">
						<input type="text" name="nombres" value="<?php echo $row ['nombres']; ?>" class="form-control" placeholder="Nombres" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Dirección</label>
					<div class="col-sm-3">
						<input type="text" name="direccion" value="<?php echo $row ['direccion']; ?>" class="form-control" placeholder="Email" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Teléfono</label>
					<div class="col-sm-3">
						<input type="text" name="telefono" value="<?php echo $row ['telefono']; ?>" class="form-control" placeholder="Teléfono" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-3">
						<select name="estado" class="form-control">
							<option value="">- Selecciona estado -</option>
                            <option value="1" <?php if ($row ['estado']==1){echo "selected";} ?>>Activo</option>
							<option value="2" <?php if ($row ['estado']==2){echo "selected";} ?>>Suspendido</option>
							<option value="3" <?php if ($row ['estado']==3){echo "selected";} ?>>Inactivo</option>
						</select> 
					</div>
                   
                </div>
				<div class="form-group">
					<label class="col-sm-3 control-label">&nbsp;</label>
					<div class="col-sm-6">
						<!-- Boton de tipo submit el cual manda los datos del formulario por un post -->
						<input type="submit" name="save" class="btn btn-sm btn-primary" value="Guardar datos">
						<!-- Es un link el cual redirige al inicio de la pagina -->
						<a href="index.php" class="btn btn-sm btn-danger">Cancelar</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
	$('.date').datepicker({
		format: 'dd-mm-yyyy',
	})
	</script>
</body>
</html>