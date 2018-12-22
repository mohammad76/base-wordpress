<form role="search" method="get" action="<?= home_url() ?>" id="searchform">
	<div class="input-group">
		<input type="text" class="form-control" name="s" id="s" placeholder="<?= __('Search' ,'kaprina') ?> ..." aria-label="" aria-describedby="basic-addon1">
		<div class="input-group-prepend">
			<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
		</div>
	</div>
</form>