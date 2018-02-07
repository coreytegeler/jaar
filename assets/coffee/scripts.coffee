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

	$('.select .dropdown').on 'click touchend', (e) ->
		$dropdown = $(this)
		$select = $dropdown.parents('.select')
		$options = $dropdown.find('.options')

		if !$(e.target).is('.option, .options')
			$('.dropdown.opened').not($dropdown).removeClass('opened')
			$dropdown.toggleClass('opened')

	$('.select .dropdown .option').on 'click touchend', (e) ->
		$field = $(this).parents('.select')
		$options = $field.find('.options')
		$dropdown = $options.parents('.dropdown')
		$select = $field.find('select')
		value = $(this).attr('data-value')
		$option = $select[0].value = value
		$field.find('.label').html(value)
		$dropdown.removeClass('opened')
		$options.find('.selected').removeClass('selected')
		$(this).addClass('selected')

	validateForm = (form) ->
		valid = true
		data = $(form).serializeObject()
		$fields = $form.find('.field')
		$fields.each (i, field) ->
			$field = $(field)
			$input = $field.find('input, select')
			value = $input.val()
			if $field.is('.verify')
				$primary_field = $field.prev()
				$primary_input = $primary_field.find('input')
				primary_value = $primary_input.val()
				if primary_value != value
					$primary_field.addClass('error')
					$field.addClass('error')
					$input.focus()
					valid = false
			if $field.is('.required') && !value || $input.is(':invalid')
				$field.addClass('error')
				valid = false
			return true
		return valid

	updateInput = (e) ->
		console.log '!'

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