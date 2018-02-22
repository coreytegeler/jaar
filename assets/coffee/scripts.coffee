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


	$('.field.select, .field.date').on 'click touchend', (e) ->
		$field = $(this)
		$inner = $field.find('.inner')
		if !$(e.target).is('.option, .ui-datepicker-header *')
			if $opened = $('.field.opened').not($field)
				$opened.removeClass('opened')
				$opened.find('.inner').attr('style','')
			$field.toggleClass('opened')
			if $field.is('.opened')
				innerHeight = $field.find('.content').innerHeight()
				$inner.css
					height: innerHeight
			else
				$inner.attr('style','')


	$('.select .dropdown .option').on 'click touchend', (e) ->
		$field = $(this).parents('.select')
		$options = $field.find('.options')
		$dropdown = $options.parents('.dropdown')
		$select = $field.find('select')
		value = $(this).attr('data-value')
		$option = $select[0].value = value
		$field.find('.label').html(value)
		$field.removeClass('opened focus')
		$field.find('.inner').attr('style','')
		$options.find('.selected').removeClass('selected')
		$(this).addClass('selected')

	$('.field.date .inner').datepicker
		buttonText: 'date'
		onSelect: (dateStr) ->
			$field = $(this).parents('.field')
			$inner = $field.find('.inner')
			$dropdown = $field.find('.dropdown')
			dateObj = moment(dateStr, 'MM/DD/YYYY')
			date = dateObj.format('MMMM Do YYYY')
			$field.find('.label').html(date)
			$field.find('input').val(date)
			$field.removeClass('opened')
			$inner.attr('style','')

	$('.field.date').each () ->
		$dateField = $(this)
		$dateField.find('.ui-datepicker').addClass('content')

	$('.field.email, .field.text, .field.textarea').on 'click', () ->
		$(this).find('input').focus()

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
			if $field.is('.required') && (!value || !value.length)
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
			if $field.is('.dateSubmitted')
				dateObj = moment()
				date = dateObj.format('MMMM Do YYYY')
				$field.find('input').val(date)
				
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