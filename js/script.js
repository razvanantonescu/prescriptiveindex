function validator(element, index) {
		var elem = $(element);
		var i = index;
		i++;
		var next = $('.quest_'+i);
		var parent_div = elem.parent();
		var error_count = 0;

// validate input:text
      var data_text = parent_div.find($("input[type=text].required"));
      data_text.each(function(index) {
            if ($(this).val() == "") {
                  $(this).addClass("error");
						error_count++;
            }
      });

// validate input:radio
		var data_radio = parent_div.find($("input[type=radio]"));
		var names = [];
		data_radio.each(function(){
				names[$(this).attr('name')] = true;
		});
		
		for (name in names) {
				var radio_buttons = $("input[name='" + name + "']");
				if (radio_buttons.filter(':checked').length == 0) {
						error_count++;
				} 
		}

		if(error_count != 0) {
				alert('Va rugam sa raspundeti la toate intrebarile!');
				return false;
		} else {
				parent_div.hide();
				next.fadeIn(400);
				window.scrollTo(0,0);
				return false;
		}
};

$(document).ready(function() {
		
		$("a.delete").click(function deleteQuestion(){
				var num = $(this).parent().children('.item').length;
				if (num == 1) {
						return false;
				} else {
						$('#question_' + num).remove();
						$('input[name="number_of_questions"]').attr('value', num-1);
				}
				return false;
		});
		
		
		$("form :submit").click(function (event) {
		
				var error_count = 0;
		
				// validate input:text
				var data_text = $("input[type=text].required");
				data_text.each(function(index) {
						if ($(this).val() == "") {
								$(this).addClass("error");
								error_count++;
						}
				});
		
				// validate input:radio
				var data_radio = $("input[type=radio]");
				var names = [];
				data_radio.each(function(){
						names[$(this).attr('name')] = true;
				});
				
				for (name in names) {
						var radio_buttons = $("input[name='" + name + "']");
						if (radio_buttons.filter(':checked').length == 0) {
								error_count++;
						} 
				}
				if(error_count != 0) {
						//alert(error_count);
						alert('Va rugam sa raspundeti la toate intrebarile!');
						event.preventDefault();
				}
		});
		
		$("form .required").focus(function() {
				$(this).removeClass("error")
		});
		
		//submit form on Ctrl+S
		$(window).keypress(function(event) {
			 if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
			 $("form input[name=submit]").click();
			 event.preventDefault();
			 return false;
		});
		
		$('#filter').change(function() {
			var selected_filter = $(this).val();
			var selected_value = $("#"+selected_filter);
			$(".values").removeClass("selected").attr('disabled', 'disabled').fadeOut(10);
			selected_value.addClass("selected").removeAttr('disabled').delay(10).fadeIn(10);
		});
		
		$('#info .info.toggle').click(function() {
				$('#info .info.content').slideToggle(200);
				$(this).toggleClass('active-toggle');
		});

});