var ready = false;
var escape_pushed = false;

var key_timeout = 500; // how close does double-press need to be?

// figure out the field names based on fields displayed
$(document).ready(function() {
  // collect the field IDs
  var ids = Array();
  $.each($('.publish_field'), function() {
    ids.push($(this).attr('id'));
  });
  var post_data = {'ids[]': ids};
  // retrieve the names
  $.post(act_url, post_data, function(data) {
    $.each(data, function(k, v) {
      if ($('#' + k).length) {
        var $fieldname = $('<span class="fieldname-reveal">').html('{' + v + '}');
        $('#' + k).find('label.hide_field').append($fieldname);
        $fieldname.hide();
      }
    });
    ready = true;
  }, 'json');
});

var toggleFieldNames = function() {
  $('span.fieldname-reveal').toggle();
};

$(document).keypress(function(e) {
  if (ready && e.keyCode === 27) {
    if (escape_pushed) {
      // double-escape: show the fields
      toggleFieldNames();
      escape_pushed = false;
    }
    else {
      escape_pushed = true;
      setTimeout(function(){
        escape_pushed = false;
      }, key_timeout);
    }
    return false;
  }
});