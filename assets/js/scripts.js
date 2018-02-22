$(function() {
  var $form, updateInput, url, validateEmail, validateForm;
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
  $('input').on('focus', function(e) {
    var $field;
    $field = $(this).parents('.field');
    return $field.addClass('focus');
  });
  $('input').on('blur', function(e) {
    var $field;
    $field = $(this).parents('.field');
    return $field.removeClass('focus');
  });
  $('.field.select, .field.date').on('click touchend', function(e) {
    var $field, $inner, $opened, innerHeight;
    $field = $(this);
    $inner = $field.find('.inner');
    if (!$(e.target).is('.option, .ui-datepicker-header *')) {
      if ($opened = $('.field.opened').not($field)) {
        $opened.removeClass('opened');
        $opened.find('.inner').attr('style', '');
      }
      $field.toggleClass('opened');
      if ($field.is('.opened')) {
        innerHeight = $field.find('.content').innerHeight();
        return $inner.css({
          height: innerHeight
        });
      } else {
        return $inner.attr('style', '');
      }
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
    $field.removeClass('opened focus');
    $field.find('.inner').attr('style', '');
    $options.find('.selected').removeClass('selected');
    return $(this).addClass('selected');
  });
  $('.field.date .inner').datepicker({
    buttonText: 'date',
    onSelect: function(dateStr) {
      var $dropdown, $field, $inner, date, dateObj;
      $field = $(this).parents('.field');
      $inner = $field.find('.inner');
      $dropdown = $field.find('.dropdown');
      dateObj = moment(dateStr, 'MM/DD/YYYY');
      date = dateObj.format('MMMM Do YYYY');
      $field.find('.label').html(date);
      $field.find('input').val(date);
      $field.removeClass('opened');
      return $inner.attr('style', '');
    }
  });
  $('.field.date').each(function() {
    var $dateField;
    $dateField = $(this);
    return $dateField.find('.ui-datepicker').addClass('content');
  });
  $('.field.email, .field.text, .field.textarea').on('click', function() {
    return $(this).find('input').focus();
  });
  validateForm = function(form) {
    var $errors, $fields, data, errors, valid;
    valid = true;
    data = $(form).serializeObject();
    $fields = $form.find('.field');
    errors = [];
    $errors = $('.errors');
    $fields.each(function(i, field) {
      var $field, $input, $primary_field, $primary_input, date, dateObj, primary_value, value;
      $field = $(field);
      $input = $field.find('input, select');
      value = $input.val();
      if ($field.is('.email') && !validateEmail(value)) {
        errors.push('invalidEmail');
      }
      if ($field.is('.required') && (!value || !value.length)) {
        $field.addClass('error');
        errors.push('requiredField');
      }
      if ($field.is('.verify')) {
        $primary_field = $field.prev();
        $primary_input = $primary_field.find('input');
        primary_value = $primary_input.val();
        if (primary_value !== value) {
          $primary_field.addClass('error');
          $field.addClass('error');
          errors.push('unverifiedEmail');
        }
      }
      if ($field.is('.dateSubmitted')) {
        dateObj = moment();
        date = dateObj.format('MMMM Do YYYY');
        $field.find('input').val(date);
      }
      return true;
    });
    $('.errors .error').each(function(i, error) {
      var $error, id;
      $error = $(error);
      id = $error.attr('id');
      if (errors.includes(id)) {
        return $error.addClass('show');
      } else {
        return $error.removeClass('show');
      }
    });
    if (errors.length) {
      $errors.addClass('show');
      valid = false;
    } else {
      $errors.removeClass('show');
      valid = true;
    }
    return valid;
  };
  updateInput = function(e) {
    return console.log('!');
  };
  validateEmail = function(email) {
    var re;
    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
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
