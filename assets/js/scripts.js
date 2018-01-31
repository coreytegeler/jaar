$(function() {
  var $form, url;
  $form = $('form#booking_form');
  url = 'https://script.google.com/macros/s/AKfycbyimcxY-hCxs4Pc1rDjqIjhBkpON-qmcQLl7xfzvmsN7Q6frWTj/exec';
  $('#submit_booking_form').on('click', function(e) {
    var jqxhr;
    e.preventDefault();
    return jqxhr = $.ajax({
      url: url,
      method: 'GET',
      dataType: 'jsonp',
      data: $form.serializeObject(),
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        return console.log(textStatus);
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
