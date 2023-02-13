<div class="container">
	<div class="row">
		<div class="col-12 mt-5 text-center">
			<h2 class="mb-3">Subir Informe Excel (.xlsx)</h2>
			<form id="formUpExcel" action="controller/subirExcelAcepta.php" method="post" enctype="multipart/form-data">
				<div class="custom-file text-left mb-4 mt-4">
					<input type="file" name="acepta" class="custom-file-input" id="customFile">
					<label class="custom-file-label" for="customFile">Seleccionar Archivo</label>
				</div>
				<button class="btn btn-primary btn-lg mt-3" id="btnUpExcel" type="submit">Procesar...</button>
			</form>
		</div>
	</div>
</div>
