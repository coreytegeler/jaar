$(function() {
  var $form, url;
  $form = $('form');
  url = 'https://script.google.com/macros/s/AKfycbyimcxY-hCxs4Pc1rDjqIjhBkpON-qmcQLl7xfzvmsN7Q6frWTj/exec';
  $('form input[type="submit"]').on('click', function(e) {
    var jqxhr;
    e.preventDefault();
    console.log($form.serializeObject());
    return jqxhr = $.ajax({
      url: url,
      method: 'GET',
      dataType: 'jsonp',
      data: $form.serializeObject(),
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        return console.log(textStatus, errorThrown);
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
