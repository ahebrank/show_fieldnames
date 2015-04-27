// figure out the field names based on fields displayed
$(document).ready(function() {
  // collect the field IDs
  var ids = Array();
  $.each($('.publish_field'), function() {
    ids.push($(this).attr('id'));
  });
  if (ids.length) {
    // retrieve the names
    $.post(act_url, ids.join(','), function(data) {
      $.each(data, function(k, v) {
        if ($('#' + k).length) {
          var $fieldname = $('<span class="fieldname-reveal">').html('{' + v + '}');
          $('#' + k).find('label.hide_field').append($fieldname);
        }
      });
    }, 'json');
  }
});