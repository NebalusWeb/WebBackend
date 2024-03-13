api.nebalus.dev
  |- /user
  |    |- /register
  |- /games
  |    |- /cosmoventure
  |    |    |- /version
  |- /linktree
  |    |- /create
  |    |- /read
  |    |- /update
  |    |- /delete
  |- /referal
  |    |- /create
  |    |- /read
  |    |- /update
  |    |- /delete
www.nebalus.dev
  |- /static      # Is not maintained by the Slim Router but by NGINX
  |    |- /js			# Default JavaScript Ordner
  |    |- /css			# Default CSS Ordner
  |    |- /img			# Default Images Ordner
  |    |- /projects
  |    |    |- /mandelbrot
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /linktree
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /comoventure
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |    |    |- /melody
  |    |    |    |- /js
  |    |    |    |- /css
  |    |    |    |- /img
  |- /docs			# Beinhaltet die Documentation für sämtliche projecte
  |    |- /
  |- /terms
  |    |- /privacy		# Beinhaltet die Datenschutz Erklärung
  |- /account
  |    |- /register
  |    |- /login
  |    |- /dashboard
  |- /u
  |    |- /{username}   # Replace the {username} by the requested user... and if requested, it will show the linktree for the user
  |- /projects
  |    |- /mandelbrot
  |    |- /oriri
  |    |- /cosmoventure
  |    |- /melody
  |- / 			# Ist die Standard seite
  |- /linktree			# Soll ein kleiner APP sein die meine links anzeigt
  |- /ref			# Ist ein eigender Ref System
