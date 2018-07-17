<form class="search-form" action="/" method="get">
	<label>Search</label>
	<div class="input-wrapper">
		<button type="submit" class="icon icon-search"></button>
		<input type="text" name="s" value="<?php the_search_query(); ?>">
	</div>
</form>
