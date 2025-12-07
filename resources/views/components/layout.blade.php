<html>
    <head>
        <title>{{ $title ?? 'Stage' }}</title>
    </head>
    <body>
        <nav>
            <a href="/">Accueil</a>
            <a href="/offers/create">Créer une offre</a>
        </nav>
        <hr/>
        {{ $slot }} </body>
</html>