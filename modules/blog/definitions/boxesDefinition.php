<?
	//boxes defintion
	//======================================== admin area boxes ==================================
	$boxesDefinition['blog.manageBlogs'] = array(
	'name'=>'Manage blogs',
	'type'=>'admin',
	'module'=>'blog',
	'method'=>'manageBlogs',
	'template'=>'manageBlogs');
	
	$boxesDefinition['blog.manageBlog'] = array(
	'name'=>'Manage blog',
	'type'=>'admin',
	'module'=>'blog',
	'method'=>'manageBlogs',
	'template'=>'manageBlog');	
	
	$boxesDefinition['blog.manageBlogRecords'] = array(
	'name'=>'Manage blog records',
	'type'=>'admin',
	'module'=>'blog',
	'method'=>'manageBlog',
	'template'=>'manageBlogRecords');		

	$boxesDefinition['blog.manageLastLinks'] = array(
	'name'=>'New blog records for admin home',
	'type'=>'admin',
	'module'=>'blog',
	'method'=>'manageBlog',
	'template'=>'manageLastBlogRecords',
	'arguments'=>'filterMode/last');	
	//=================================== fron end boxes =======================================

	$boxesDefinition['blog.getLastBlogRecords'] = array(
	'name'=>'Last blog records list',
	'type'=>'front',
	'module'=>'blog',
	'method'=>'getBlogs',
	'template'=>'viewLastLinks',
	'arguments'=>'filterMode/last');	
	
	$boxesDefinition['blog.getBlogs'] = array(
	'name'=>'Blogs list',
	'type'=>'front',
	'module'=>'blog',
	'method'=>'getBlogs',
	'template'=>'viewBlogs');	
	
	$boxesDefinition['blog.getBlog'] = array(
	'name'=>'Blog',
	'type'=>'front',
	'module'=>'blog',
	'method'=>'getBlog',
	'template'=>'viewBlogRecords');	
	
	$boxesDefinition['blog.editBlog'] = array(
	'name'=>'Manage blog',
	'type'=>'front',
	'module'=>'blog',
	'method'=>'manageBlog',
	'template'=>'editBlog');		
	


?>