$(document).ready ->
	shrink 			= $ '#videoSize #shrink'
	enlarge 		= $ '#videoSize #enlarge'
	video 			= $ '#video'
	videoContent 	= $ '#videoContent'
	wrapper 		= $ '#wrapper'
	iframe 			= $('#iframe')[0]

	pad = (num) ->
		s = num+"";
		while (s.length < 2)
			s = "0" + s;

		return s;

	$.fn.scrollView = (quick) ->
		duration = 1000
		if quick? == true
			duration = 10

		this.each ->
			$('html, body').animate {
				scrollTop : $(this).offset().top
			}, duration

	$('form').ajaxForm {
		data : {
			src: 'ajax'
		}
		success: (responseText, statusText, xhr, $form) ->
			if (!responseText)
				alert 'No response, is the url correct?'
			else
				r = $.parseJSON responseText
				addHistory r
				loadVideo r
	}

	formatDate = (timestamp, showSeconds) ->
		d = new Date timestamp*1000
		res = d.getFullYear()+'-'+pad(d.getMonth())+'-'+pad(d.getDate())

	formatTimestamp = (timestamp, showSeconds) ->
		d = new Date timestamp*1000
		res = pad(d.getDate())+'-'+pad(d.getMonth())+'-'+d.getFullYear()+' @ '+d.getHours()+':'+pad(d.getMinutes())

		if (showSeconds?)
			res = res+':'+pad(d.getSeconds())

		res

	addHistory = (doc) ->
		historyList = $ '#historyList'
		historyItem = $ '<li/>'

		aired = formatTimestamp doc.Aired
		timestamp = formatTimestamp doc.Timestamp, true

		historyLink = $('<a/>', { href : '?id='+doc._id.$id })
		historyLink.html timestamp+' &mdash; '+doc.Title
		historyLink.click (e) ->
			e.preventDefault()
			loadVideo doc

		historyLink.appendTo historyItem

		historyContent = $ '<p/>'
		historyContent.html   'Title: '+doc.Title + 
						'<br/> Aired: '+aired + 
						'<br/> Length: '+doc.Duration
		historyContent.appendTo historyLink

		historyList.prepend historyItem

	if collection?
		addHistory doc for id, doc of collection
	

	loadVideo = (doc) ->
		video.show()
		v = $('#video video')[0]

		if doc.videoUrls?
			for u in doc.videoUrls
				if u.mimeType == 'video/mp4'
					src = u.Location

			if !src
				src = doc.videoUrls[0].Location

			l = $ '#video a#download'
			l.attr 'href', src
			aired = formatDate doc.Aired

			fileName = (aired+'-'+doc.Title).replace(' ','_')+'.mp4'
			l.attr 'download', fileName
			l.html 'Download '+fileName

			v.src = src
			v.load()
			video.scrollView()
		else
			alert 'Something has gone tits up..'


	if collegeramaDocument?
			loadVideo $.parseJSON collegeramaDocument


	$(videoSize).click (e) ->
		e.preventDefault()

		if shrink.css('display') == 'none'
			shrink.css 'display', 'block'
			enlarge.css 'display', 'none'
			$('section[id!=video]').css 'display', 'none'
			videoContent.css 
				position : 'absolute'
			
			$('#video h1').css
				padding : '.2em .2em 0 .2em'

		else
			shrink.css 'display', 'none'
			enlarge.css 'display', 'block'
			$('section[id!=video]').css 'display', 'block'
			videoContent.css 
				position 	: 'relative'
			
			$('#video h1').css
				padding : 0

			video.scrollView(true)

	$('#linksShow3mE').click (e) ->
		e.preventDefault()
		$('#linksIframe').show().scrollView()
		iframe.src = 'http://collegerama.tudelft.nl/Mediasite/Catalog/Full/cf028e9a2a244e1fbdb52ace3f9cd42d21'
