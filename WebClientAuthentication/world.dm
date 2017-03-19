client
	New()
		. = ..()
		world.log << src.key
		if(IsGuestKey(src.key))
			world.log << "[src.key] is a guest"
			winset(src, "log", "is-visible=true")
			src << output("Please login to a BYOND account and try again", "log")
			return FALSE


		winset(src, "log", "is-visible=true")
		src << output("Contacting server...", "log")

		var/payload = url_encode(src.key)
		var/http[] = world.Export("http://127.0.0.1:9000/storeCkey.php?ckey=[payload]")
		if(!http)
			src << output("Server is down. please try again later.", "log")
			return FALSE

		src << output("Redirecting...", "log")

		var/F = file2text(http["CONTENT"])
		if(F)
			src << output("[F]", "redirector")
