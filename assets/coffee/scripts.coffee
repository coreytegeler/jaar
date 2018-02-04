$ () ->
	$form = $('form')
	url = 'GOOGLE_SCRIPT'

	$('form').on 'submit', (e) ->
		e.preventDefault()
		data = $(this).serializeObject()
		console.log data
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