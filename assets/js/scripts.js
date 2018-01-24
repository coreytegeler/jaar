$(function() {
  var $form, url;
  $form = $('form#booking_form');
  url = GOOGLE_SCRIPT;
  $('#submit_booking_form').on('click', function(e) {
    var jqxhr;
    e.preventDefault();
    return jqxhr = $.ajax({
      url: url,
      method: "GET",
      dataType: "jsonp",
      data: $form.serializeObject(),
      error: function(jqXHR, textStatus, errorThrown) {
        return console.log(jqXHR);
      },
      success: function(data, textStatus, jqXHR) {
        return console.log(data);
      }
    });
  });
  return $.fn.serializeObject = function() {
    var a, o;
    o = {};
    a = this.serializeArray();
    $.each(a, function() {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        return o[this.name].push(this.value || '');
      } else {
        return o[this.name] = this.value || '';
      }
    });
    return o;
  };
});
