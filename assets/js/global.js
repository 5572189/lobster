(function() {
    $(document).ready(function() {
        setValidateForm();
        
		if( $('.datetimepicker').length != 0 ){
			$(".datetimepicker").datetimepicker();
		}
		
		$('.btn-dropdown-search .dropdown-menu a').click(function(){
			var type = $(this).attr('data'),
				type_name = $(this).html();
			$(this).parents('.btn-dropdown-search').find('.dropdown-toggle').html(type_name+' <span class="caret"></span>');
			$(this).parents('.btn-dropdown-search').next('input[name="searchtype"]').val(type);
		});
		
    });
	
	this.setValidateForm = function(selector) {
        if (selector == null) {
            selector = $(".validate-form");
        }
        return selector.each(function(i, elem) {
            return $(elem).validate({
                errorElement: "span",
                errorClass: "help-block error",
                errorPlacement: function(e, t) {
                    return t.parents(".controls").append(e);
                },
                highlight: function(e) {
                    return $(e).closest(".control-group").removeClass("error success").addClass("error");
                },
                success: function(e) {
                    return e.closest(".control-group").removeClass("error");
                }
            });
        });
    };

}).call(this);