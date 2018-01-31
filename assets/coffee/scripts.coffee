$ () ->
	$form = $('form#booking_form')
	url = 'GOOGLE_SCRIPT'

	$('#submit_booking_form').on 'click', (e) ->
		e.preventDefault()
		jqxhr = $.ajax
			url: url,
			method: "GET",
			dataType: "jsonp",
			data: $form.serializeObject()
			error: (jqXHR, textStatus, errorThrown) ->
				console.log jqXHR
			success: (data, textStatus, jqXHR) ->
				console.log data


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