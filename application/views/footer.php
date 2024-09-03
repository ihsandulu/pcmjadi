

	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	});
	$(document).ready(function(){
		$('[data-toggle="popover"]').popover(); 
	});	
	
	 $( function() {
		$( ".date" ).datepicker({
          dateFormat: "yy-mm-dd",
		  changeMonth: true,
		  changeYear: true
        });
	  } );
	

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
		
	function tampilimg(a){
		$("#imgumum").attr('src',$(a).attr('src'));
		$("#myImage").modal();	
	}
	
	
  $( function() {
    $( "#dataTable" ).draggable({ axis: "x" , containment: "parent"  });
    $( "#dataTable1" ).draggable({ axis: "x" , containment: "parent"  });
  } );
  </script>	