$(function() {
  var $body, $card, setupCard, setupForm, setupPage, showContent, siteUrl, validateEmail, validateForm;
  $body = $('body');
  $card = $('#card');
  siteUrl = $body.attr('data-site-url');
  setupPage = function() {
    var $content;
    setupCard();
    if ($content = $card.find('.content').first()) {
      $content.addClass('front').addClass('show');
    }
    return $('nav a').each(function() {
      if (this.href.indexOf(siteUrl) === -1) {
        return $(this).addClass('external').attr('target', '_blank');
      }
    });
  };
  setupCard = function() {
    var $content, form;
    $content = $card.find('.content').first();
    if (form = $content.find('form')) {
      setupForm(form);
    }
    return $content.find('a').each(function() {
      if (this.href.indexOf(siteUrl) === -1) {
        return $(this).addClass('external').attr('target', '_blank');
      }
    });
  };
  $body.on('click', 'nav a', function(e) {
    var $link, $newContent, $oldContent, href, id, oldId;
    $link = $(this);
    if ($link.is('.external')) {
      return;
    }
    e.preventDefault();
    if ($link.is('.opened')) {
      return;
    }
    e.preventDefault();
    href = this.href;
    history.pushState(null, null, href);
    $('nav .opened').removeClass('opened');
    $link.addClass('opened');
    $oldContent = $card.find('.content.show');
    oldId = $oldContent.attr('id');
    if ($link.is('.loaded')) {
      id = $link.attr('data-id');
      $newContent = $card.find('.content#' + id);
      return showContent($newContent);
    } else {
      return $.ajax({
        type: 'POST',
        data: {
          request: true
        },
        url: href,
        success: function(content, textStatus, jqXHR) {
          var $content;
          $content = $(content).clone();
          id = $content.attr('id');
          $newContent = $card.find('#' + id);
          if (!$newContent.length) {
            $newContent = $content;
            $card.prepend($newContent);
          }
          if (oldId !== id) {
            showContent($newContent);
          }
          $link.attr('data-id', id).addClass('loaded');
          return setupCard();
        }
      });
    }
  });
  showContent = function($newContent) {
    $card.find('.content').not($newContent).removeClass('show');
    $newContent.addClass('show');
    return $card.addClass('show');
  };
  $body.on('click touchstart', '#card .close', function() {
    if ($card.is('.show')) {
      $('nav .opened').removeClass('opened');
      $card.attr('class', '');
      return history.pushState(null, null, siteUrl);
    }
  });
  $body.on('submit', 'form', function(e) {
    var $form, data, isValidated, jqxhr, scriptUrl;
    e.preventDefault();
    $form = $(this);
    scriptUrl = $form.attr('data-script');
    if ($form.is('.submitted')) {
      return;
    }
    isValidated = validateForm(this);
    if (isValidated) {
      data = $(this).serializeObject();
      return jqxhr = $.ajax({
        url: scriptUrl,
        method: 'POST',
        dataType: 'json',
        data: data,
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          return console.log(textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          return $form.addClass('submitted');
        }
      });
    }
  });
  $body.on('focus', 'input, textarea', function(e) {
    var $field;
    $field = $(this).parents('.field');
    return $field.addClass('focus');
  });
  $body.on('blur', 'input, textarea', function(e) {
    var $field;
    $field = $(this).parents('.field');
    return $field.removeClass('focus');
  });
  $body.on('click', '.field.select, .field.date', function(e) {
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
        innerHeight = $field.find('.options').innerHeight();
        return $inner.css({
          height: innerHeight
        });
      } else {
        return $inner.attr('style', '');
      }
    }
  });
  $body.on('click', '.select .dropdown .option', function(e) {
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
  $body.on('click', '.field.email, .field.text, .field.textarea', function() {
    return $(this).find('input').focus();
  });
  setupForm = function(form) {
    if ($(form).is('.setup')) {
      return;
    }
    $(form).addClass('setup');
    $(form).find('.field.date .inner').datepicker({
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
    return $('.field.date').each(function() {
      var $dateField;
      $dateField = $(this);
      return $dateField.find('.ui-datepicker').addClass('options');
    });
  };
  validateForm = function(form) {
    var $errors, $fields, $form, data, errors, valid;
    valid = true;
    $form = $(form);
    data = $form.serializeObject();
    $fields = $form.find('.field');
    errors = [];
    $errors = $('.errors');
    $fields.each(function(i, field) {
      var $field, $input, $primary_field, $primary_input, primary_value, value;
      $field = $(field);
      $input = $field.find('input, select, textarea');
      value = $input.val();
      if ($field.is('.email') && !validateEmail(value)) {
        errors.push('invalidEmail');
      }
      if ($field.is('.required') && (!value || !value.length)) {
        $field.addClass('error');
        errors.push('requiredField');
      } else {
        $field.removeClass('error');
      }
      if ($field.is('.verify')) {
        $primary_field = $field.prev();
        $primary_input = $primary_field.find('input');
        primary_value = $primary_input.val();
        if (primary_value !== value) {
          $primary_field.addClass('error');
          $field.addClass('error');
          errors.push('unverifiedEmail');
        } else {
          $field.removeClass('error');
        }
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
  validateEmail = function(email) {
    var re;
    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  };
  $.fn.serializeObject = function() {
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
  return setupPage();
});
