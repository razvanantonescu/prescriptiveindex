   function add_question(element) {
      var elem = $(element);
      var q_index = elem.parent().prev().children('.question.item').size()+1;
      
      $.ajax({
         type: "POST",
         url: "process.php",
         data: "action=add_question&question_index="+q_index,
         success: function(data) {
            elem.parent().prev().append(data);
         }
      });

      $('input[name="number_of_questions"]').attr('value', q_index);


   };

   function add_choice(element) {
      
      var elem = $(element);
      
      var q_id = elem.parent().parent().attr('id');
      var q_index = q_id.split('_')[1];
      var c_index = elem.parent().prev().children('.choice.item').size()+1;
      
      $.ajax({
         type: "POST",
         url: "process.php",
         data: "action=add_choice&question_index="+q_index+"&choice_index="+c_index,
         success: function(data) {
            elem.parent().prev().append(data);
         }
      });
      //alert('input[name="number_of_choices_q'+q_index+'"]');
      $('input[name="number_of_choices_q'+q_index+'"]').attr('value', c_index);
    };


   function delete_question(element) {
      var elem = $(element);
      var num = elem.parent().parent().find('.question.item').size();
      if (num == 1) {
            return false;
      } else {
            $('#question_' + num).remove();
            $('input[name="number_of_questions"]').attr('value', num-1);
            return true;
      }
   };

   function delete_choice(element) {
      var elem = $(element);
      var q_id = elem.parent().parent().attr('id');
      var q_index = q_id.split('_')[1];

      var num = elem.parent().parent().find('.choice.item').size();
      if (num == 1) {
            return false;
      } else {
            $('#question_' + q_index + '_choice_' + num).remove();
            $('input[name="number_of_choices_q'+q_index+'"]').attr('value', num-1);
            return true;
      }
   };
   
   function toggle_question_type(element) {
      var elem = $(element);
      var q_id = elem.parent().attr('id');
      var q_index = q_id.split('_')[1];

      var option = elem.val();
      
      if (option == 'text') {
         elem.parent().children('.choice').remove();
         $('input[name="number_of_choices_q'+q_index+'"]').attr('value', 0);         
         elem.parent().children('.controls').hide();
         return true;
      }
      if (option == 'choice') {
         //elem.parent().children('.choice').show();
         elem.parent().children('.controls').show();
         return true;
      }
      
      
   }