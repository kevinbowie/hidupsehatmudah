
<style type="text/css">
.alignleft{
	float: left;
}

.alignright{
	float: right;
}
#category{
	width: 200px;
}
#title, #subcategory, #category1{
	width: 300px;
}
#catdescription, #subcatdescription{
	width: 500px;
}
</style>

<div id="new-calories-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" onSubmit="return validateForm()">
	  	<div class="modal-body">
			<div class="container">
				<div class="modal-dialog modal-lg">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">TAMBAH DAFTAR</h2></div>
							<div class="form-group" id="title">
								<label for="Menu">Judul</label>
								<input type="text" name="title" value="" class="form-control input-small">
							</div>
							<div class="form-group" id="category">
								<label for="category">Kategori</label>
								<select class="form-control" name="category">
									<option value="0" selected>Kategori</option>
							<?php $__currentLoopData = $subCat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php
								echo "<option value='" . $values->category_list . "'>" . $values->category_list . "</option>"; ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</select>
							</div>		
							<div class="form-group" id="titledescription">
						  		<label for="TitleDescription">Deskripsi Judul:</label>
							  	<textarea class="form-control" rows="3" name="titledescription"></textarea>
							</div> 
							<div class="row"> <?php
								if ($jenis == 'food'){ ?>
									<div class="form-group col-sm-2" id="protein">
										<label for="protein">Protein</label>
										<input type="text" name="protein" value="" class="form-control input-small">
									</div>	
									<div class="form-group col-sm-2" id="carbohydrate">
										<label for="carbohydrate">Karbohidrat</label>
										<input type="text" name="carbohydrate" value="" class="form-control input-small">
									</div>	
									<div class="form-group col-sm-2" id="lipid">
										<label for="lipid">Lemak</label>
										<input type="text" name="lipid" value="" class="form-control input-small">
									</div>	
									<div class="form-group col-sm-2" id="urt">
										<label for="bdd">BDD</label>
										<input type="text" name="bdd" value="" class="form-control input-small">
									</div>	<?php
								}
								else{ ?>
									<div class="form-group col-sm-2" id="carbohydrate">
										<label for="carbohydrate">Kalori</label>
										<input type="text" name="carbohydrate" value="" class="form-control input-small">
									</div>	
									<div class="form-group col-sm-2" id="portion">
										<label for="portion">Waktu (Jam)</label>
										<input type="text" name="portion" value="1" class="form-control input-small" readonly>
									</div>
									<div class="form-group col-sm-2" id="urt">
										<label for="urt">Satuan</label>
										<input type="text" name="portion" value="Jam" class="form-control input-small" readonly>
									</div>	<?php
								} ?>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
							<button class="btn btn-primary" id="new-calories" type="submit">Tambah</button>
						</div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>


<div id="new-category-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" onSubmit="return validateForms()" action="<?php echo e(url('calories/category/add')); ?>">
	  	<div class="modal-body">
			<div class="container">
				<div class="modal-dialog modal-lg">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">TAMBAH KATEGORI</h2></div>
							<div class="form-group" id="category1">
								<label for="Menu">Kategori</label>
								<input type="hidden" name="jenis" value="">
								<input type="text" name="category1" value="" class="form-control input-small">
							</div>
							<div class="form-group" id="description">
						  		<label for="Description">Deskripsi:</label>
							  	<textarea class="form-control" rows="3" name="description"></textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
							<button class="btn btn-primary" id="new-category" type="submit">Tambah</button>
						</div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>


<div id="new-unit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
	<form method="post" onSubmit="return validateFormUnit()" action="<?php echo e(url('calories/satuan/add')); ?>">
	  	<div class="modal-body">
			<div class="container">
				<div class="modal-dialog">
			    	<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
							<div class="page-header"><h2 class="text-center">TAMBAH SATUAN</h2></div>
							<input type="hidden" name="jenis" value="">
							<div class="form-group" id="categoryList" style="width: 200px;">
								<label for="Category">Kategori</label>
								<input type="text" name="categoryList" value="" class="form-control input-small" readonly>
							</div>
							<div class="form-group" id="satuan" style="width: 200px;">
						  		<label for="Satuan">Satuan</label>
								<input type="text" name="satuan" value="" class="form-control input-small">
							</div>
							<div class="form-group" id="satuanAda">
						  		<label for="SatuanAda">Satuan yang Sudah Ada</label><br>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
							<button class="btn btn-primary" id="new-category" type="submit">Tambah</button>
						</div>
			    	</div>
			    </div>
			</div>
	  	</div>
	</form>
</div>
