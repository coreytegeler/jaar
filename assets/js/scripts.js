$(function() {
  var $form, updateInput, url, validateForm;
  $form = $('form');
  url = 'https://script.google.com/macros/s/AKfycbyimcxY-hCxs4Pc1rDjqIjhBkpON-qmcQLl7xfzvmsN7Q6frWTj/exec';
  $('form').on('submit', function(e) {
    var data, jqxhr, validated;
    e.preventDefault();
    if ($form.is('.submitted')) {
      return;
    }
    validated = validateForm(this);
    if (validated) {
      data = $(this).serializeObject();
      return jqxhr = $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        data: data,
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          return console.log(textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          console.log(data);
          return $form.addClass('submitted');
        }
      });
    }
  });
  $('.select .dropdown').on('click touchend', function(e) {
    var $dropdown, $options, $select;
    $dropdown = $(this);
    $select = $dropdown.parents('.select');
    $options = $dropdown.find('.options');
    if (!$(e.target).is('.option, .options')) {
      $('.dropdown.opened').not($dropdown).removeClass('opened');
      return $dropdown.toggleClass('opened');
    }
  });
  $('.select .dropdown .option').on('click touchend', function(e) {
    var $dropdown, $field, $option, $options, $select, value;
    $field = $(this).parents('.select');
    $options = $field.find('.options');
    $dropdown = $options.parents('.dropdown');
    $select = $field.find('select');
    value = $(this).attr('data-value');
    $option = $select[0].value = value;
    $field.find('.label').html(value);
    $dropdown.removeClass('opened');
    $options.find('.selected').removeClass('selected');
    return $(this).addClass('selected');
  });
  validateForm = function(form) {
    var $fields, data, valid;
    valid = true;
    data = $(form).serializeObject();
    $fields = $form.find('.field');
    $fields.each(function(i, field) {
      var $field, $input, $primary_field, $primary_input, primary_value, value;
      $field = $(field);
      $input = $field.find('input, select');
      value = $input.val();
      if ($field.is('.verify')) {
        $primary_field = $field.prev();
        $primary_input = $primary_field.find('input');
        primary_value = $primary_input.val();
        if (primary_value !== value) {
          $primary_field.addClass('error');
          $field.addClass('error');
          $input.focus();
          valid = false;
        }
      }
      if ($field.is('.required') && !value || $input.is(':invalid')) {
        $field.addClass('error');
        valid = false;
      }
      return true;
    });
    return valid;
  };
  updateInput = function(e) {
    return console.log('!');
  };
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
