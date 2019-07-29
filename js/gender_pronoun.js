(function($) {
  var gender_pronoun_custom_field = $('.gender_pronoun_custom_field_text_box').parent().parent();
  var fieldSet =  $('.gender_pronoun_custom_field_text_box').parent().parent().parent();
  fieldSet.append('<div id="pronoun_custom_options"></div><div id="pronoun_custom_field"></div>');
  $('#pronoun_custom_field').append(gender_pronoun_custom_field);
  var gender_pronoun_options = $('.editrow_pronoun_options');
  console.log(gender_pronoun_options);
  $('#pronoun_custom_options').append(gender_pronoun_options);
  $('#pronoun_custom_field').hide();
  gender_pronoun_options.change(function() {
    var gender_pronoun = $('.editrow_pronoun_options option:selected').text();
    if (gender_pronoun == "Other") {
      $('#pronoun_custom_field').show();
    }
    else {
      $('#pronoun_custom_field').hide();
      $('.gender_pronoun_custom_field_text_box').val(gender_pronoun);
    }
  });
})(CRM.$);
