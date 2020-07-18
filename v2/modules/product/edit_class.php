<form method="post" id="editClassForm" name="editClassForm" enctype="multipart/form-data">
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$("#editShopForm").validate({
			debug: false,
			rules: {
				cooshopName: "required",
				cooshopURL: {
					required: true,
				},
				cooshopHier: "required",
				cooshopPrevious: "required"
			},
			messages: {
				cooshopName: "*",
				cooshopURL:  "*",
				cooshopPrevious: "required",
				cooshopHier: "*",
			},
			submitHandler: function(form) {
				// do other stuff for a valid form
				$.post('modules/product/editshop.php', $("#editShopForm").serialize(), function(data) {
					$('#results').html(data);
				});
			}
		});
	});
</script>