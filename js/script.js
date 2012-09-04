$(document).ready(function() {
      //alert("test");

$("a.add").click(function addQuestion(){

      var parent = $(this).parent();
      var num = $(this).parent().children('.item').length;
      var newNum  = new Number(num + 1);
      
      var previous_item = $('#question_' + num);
      var newElem = previous_item.clone(true);

      newElem.attr('id', 'question_'+ newNum);
      
      var newElemId = newElem.attr("id");
      newElem.children('h3').children('.number').text(num+1);
      newElem.find('input').attr('value', '');
      newElem.children('input.question_id').remove();
      newElem.children('fieldset.title').children('.ro').children('label').attr('for', newElemId+'_ro');
      newElem.children('fieldset.title').children('.ro').children('input').attr('name', newElemId+'_ro');
      newElem.children('fieldset.title').children('.en').children('label').attr('for', newElemId+'_en');
      newElem.children('fieldset.title').children('.en').children('input').attr('name', newElemId+'_en');

      var choices = newElem.children('.choice').children('.item');
      choices.each(function(index){

	var a = new Array();
	a[1] = 'Acord puternic';
	a[2] = 'Intrucatva de acord';
	a[3] = 'Dezacord partial';
	a[4] = 'Dezacord puternic';
	a[5] = '-';

            var i = index+1;
            $(this).attr('id', newElemId + '_choice_'+i);
            var choice_id = $(this).attr('id');
            $(this).children('fieldset.title').children('.ro').children('label').attr('for', choice_id+'_ro');
            $(this).children('fieldset.title').children('.ro').children('input').attr('name', choice_id+'_ro');
//	$(this).children('fieldset.title').children('.ro').children('input').val(a[i]);
            $(this).children('fieldset.title').children('.en').children('label').attr('for', choice_id+'_en');
            $(this).children('fieldset.title').children('.en').children('input').attr('name', choice_id+'_en');
//	$(this).children('fieldset.title').children('.en').children('input').val(a[i]);
            $(this).children('fieldset.score').children('label').attr('for', choice_id+'_score');
            $(this).children('fieldset.score').children('input').attr('name', choice_id+'_score');  
//	$(this).children('fieldset.score').children('input').val(i);
      });
      
      previous_item.after(newElem);
      $('input[name="number_of_questions"]').attr('value', newNum);
      return false;

});


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
      var data = $(".required");
      data.each(function(index) {
            if ($(this).val() == "") {
                  $(this).addClass("error");
            }
      });
      var error = $(".error");
      if(error.length != 0) {
            console.log("erori");
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

});//end of $(document).ready