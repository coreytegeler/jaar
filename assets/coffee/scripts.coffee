$ () ->
	$form = $('form')
	url = 'GOOGLE_SCRIPT'

	$('form').on 'submit', (e) ->
		e.preventDefault()
		if $form.is('.submitted')
			return
		validated = validateForm(this)
		if validated
			data = $(this).serializeObject()
			jqxhr = $.ajax
				url: url,
				method: 'GET',
				dataType: 'json',
				data: data
				error: (jqXHR, textStatus, errorThrown) ->
					console.log jqXHR
					console.log textStatus, errorThrown
				success: (data, textStatus, jqXHR) ->
					console.log data
					$form.addClass('submitted')

	$('input').on 'focus', (e) ->
		$field = $(this).parents('.field')
		$field.addClass('focus')

	$('input').on 'blur', (e) ->
		$field = $(this).parents('.field')
		$field.removeClass('focus')


	$('.select .dropdown').on 'click touchend', (e) ->
		$dropdown = $(this)
		$field = $dropdown.parents('.field')
		$select = $dropdown.parents('.select')
		$options = $dropdown.find('.options')
		if !$(e.target).is('.option, .options')
			if $opened = $('.dropdown.opened').not($dropdown)
				$opened.removeClass('opened')
				$opened.find('.options').attr('style','')
			$dropdown.toggleClass('opened')
			if $dropdown.is('.opened')
				optionsHeight = $dropdown.find('.inner').innerHeight()
				$options.css
					height: optionsHeight
			else
				$options.attr('style','')


	$('.select .dropdown .option').on 'click touchend', (e) ->
		$field = $(this).parents('.select')
		$options = $field.find('.options')
		$dropdown = $options.parents('.dropdown')
		$select = $field.find('select')
		value = $(this).attr('data-value')
		$option = $select[0].value = value
		$field.find('.label').html(value)
		$dropdown.removeClass('opened')
		$field.removeClass('focus')
		$options.find('.selected').removeClass('selected')
		$(this).addClass('selected')

	validateForm = (form) ->
		valid = true
		data = $(form).serializeObject()
		$fields = $form.find('.field')
		errors = []
		$errors = $('.errors')
		$fields.each (i, field) ->
			$field = $(field)
			$input = $field.find('input, select')
			value = $input.val()
			if $field.is('.email') && !validateEmail(value)
				errors.push('invalidEmail')
			if $field.is('.required') && !value || !value.length
				$field.addClass('error')
				errors.push('requiredField')
			if $field.is('.verify')
				$primary_field = $field.prev()
				$primary_input = $primary_field.find('input')
				primary_value = $primary_input.val()
				if primary_value != value
					$primary_field.addClass('error')
					$field.addClass('error')
					errors.push('unverifiedEmail')
			return true

		$('.errors .error').each (i, error) ->
			$error = $(error)
			id = $error.attr('id')
			if errors.includes(id)
				$error.addClass('show')
			else
				$error.removeClass('show')

		if errors.length
			$errors.addClass('show')
			valid = false
		else
			$errors.removeClass('show')
			valid = true

		return valid

	updateInput = (e) ->
		console.log '!'

	validateEmail = (email) ->
    re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(String(email).toLowerCase())

	$.fn.serializeObject = () ->
		o = {}
		a = this.serializeArray()
		$.each a, () ->
			if(o[this.name])
				if (!o[this.name].push)
					 o[this.name] = [o[this.name]]
				o[this.name].push(this.value || '')
			else
				o[this.name] = this.value || ''
		return o