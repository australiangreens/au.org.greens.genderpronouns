(function($) {
  var pronoun_custom_field = $('.pronoun_custom_field_text_box').parent().parent();
  var fieldSet =  $('.pronoun_custom_field_text_box').parent().parent().parent();
  fieldSet.append('<div id="pronoun_custom_options"></div><div id="pronoun_custom_field"></div><div id="profile-submit-buttons"></div>');
  $('#pronoun_custom_field').append(pronoun_custom_field);
  var pronoun_options = $('.editrow_pronoun_options');
  $('#pronoun_custom_options').append(pronoun_options);
  $('#pronoun_custom_field').hide();
  if (CRM.vars.pronouns.profile) {
    $('#profile-submit-buttons').append($('.crm-submit-buttons'));
  }
  pronoun_options.change(function() {
    var pronoun = $('.editrow_pronoun_options option:selected').text();
    if (pronoun == "Other") {
      $('#pronoun_custom_field').show();
    }
    else {
      $('#pronoun_custom_field').hide();
      $('.pronoun_custom_field_text_box').val(pronoun);
    }
  });
})(CRM.$);
