		<script type="text/javascript">
		$(function() {
			$("#q").keyup(function(){
				var search = $("#q").val();
				$.ajax({
					type: "GET",
					url: "/monitoring/phones/search",
					data: {"q": search},
					cache: false,						
					success: function(response){
						$("#RS").html(response);
						//alert(response);
					}
				});
				return false;
			});
		});
		</script>
<h1>Список телефонов компании</h1>
<form class="simple" action="<?= base_url('monitoring/phones/search');?>" onsubmit="return false;">
    <p>
        Поиск:<br> 
        <input name="q" type="text" id="q" autocomplete="off" style="width: 100%" />
    </p>
</form>
<div id="RS">Начните вводить запрос</div>