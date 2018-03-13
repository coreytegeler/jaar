$ () ->
	$body = $('body')
	$card = $('#card')
	siteUrl = $body.attr('data-site-url')

	$card.find('.content').first().addClass('front').addClass('show')

	$('nav a').each () ->
		if this.href.indexOf(siteUrl) == -1
			$(this).addClass('external').attr('target', '_blank')

	$(window).resize () ->
		$content = $card.find('.content.new')
		if $content.length
			$card.css
				height: $content.innerHeight()

	$body.on 'click', 'nav a', (e) ->
		$link = $(this)
		if $link.is('.external')
			return
		e.preventDefault()
		if $link.is('.opened')
			return
		e.preventDefault()	
			
		href = this.href
		history.pushState(null, null, href)

		$('nav .opened').removeClass('opened')
		$link.addClass('opened')

		

		$oldContent = $card.find('.content.show')
		oldId = $oldContent.attr('id')

		if $link.is('.loaded')
			id = $link.attr('data-id')
			$newContent = $card.find('.content#'+id)
			flipTo($newContent, $oldContent)
		else
			$.ajax
				type: 'POST',
				data:
					request: true
				url: href,
				success: (content, textStatus, jqXHR) ->
					$content = $(content).clone()
					id = $content.attr('id')
					$newContent = $card.find('#'+id)
					if !$newContent.length
						$newContent = $content
						$card.prepend($newContent)
					if oldId != id
						flipTo($newContent, $oldContent)
					if form = $newContent.find('form')
						setupForm(form)
					$link.attr('data-id', id).addClass('loaded')

					
	flipTo = ($newContent, $oldContent) ->
		if $card.is('.flipped')
			oldClass = 'back'
			newClass = 'front'
		else
			oldClass = 'front'
			newClass = 'back'

		$card.find('.content').not($oldContent).not($newContent).removeClass('front back show')
		$oldContent.removeClass(newClass).addClass(oldClass).removeClass('show')
		$newContent.removeClass(oldClass).addClass(newClass).addClass('show')

		if $card.is('.show')
			$card.toggleClass('flipped')

		$card.addClass('show').css
			height: $newContent.innerHeight()

	$body.on 'click', '#card .close', () ->
		if $card.is('.show')
			$('nav .opened').removeClass('opened')
			$card.attr('class', '')
			history.pushState(null, null, siteUrl)
		
	$body.on 'submit', 'form', (e) ->
		e.preventDefault()
		$form = $(this)
		scriptUrl = $form.attr('data-script')
		if $form.is('.submitted')
			return
		isValidated = validateForm(this)
		if isValidated
			data = $(this).serializeObject()
			jqxhr = $.ajax
				url: scriptUrl,
				method: 'POST',
				dataType: 'json',
				data: data
				error: (jqXHR, textStatus, errorThrown) ->
					console.log jqXHR
					console.log textStatus, errorThrown
					console.log data
					console.log scriptUrl
				success: (data, textStatus, jqXHR) ->
					console.log data
					$form.addClass('submitted')

	$body.on 'focus', 'input, textarea', (e) ->
		$field = $(this).parents('.field')
		$field.addClass('focus')

	$body.on 'blur', 'input, textarea', (e) ->
		$field = $(this).parents('.field')
		$field.removeClass('focus')


	$body.on 'click touchend', '.field.select, .field.date', (e) ->
		$field = $(this)
		$inner = $field.find('.inner')
		if !$(e.target).is('.option, .ui-datepicker-header *')
			if $opened = $('.field.opened').not($field)
				$opened.removeClass('opened')
				$opened.find('.inner').attr('style','')
			$field.toggleClass('opened')
			if $field.is('.opened')
				innerHeight = $field.find('.options').innerHeight()
				$inner.css
					height: innerHeight
			else
				$inner.attr('style','')


	$body.on 'click touchend', '.select .dropdown .option', (e) ->
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

	$body.on 'click', '.field.email, .field.text, .field.textarea', () ->
		$(this).find('input').focus()

	setupForm = (form) ->
		if $(form).is('.setup')
			return
		$(form).addClass('setup')
		$(form).find('.field.date .inner').datepicker
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

	if form = $card.find('form')
		setupForm(form)

	validateForm = (form) ->
		valid = true
		$form = $(form)
		data = $form.serializeObject()
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