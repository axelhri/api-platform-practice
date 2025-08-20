const Encore = require('@symfony/webpack-encore');

// ...
Encore
    // Tes autres configurations Encore (entry, enableSass, etc.)
    .configureDevServerOptions(options => {
        // Configuration HTTPS avec tes certificats
        options.server = {
            type: 'https',
            options: {
                key: '/.docker/traefik/certs/agorafolk.key',
                cert: '/.docker/traefik/certs/agorafolk.crt',
            }
        };

        // Active le Live Reload pour les fichiers PHP/Twig
        options.liveReload = true;

        // Désactive la surveillance des fichiers statiques (déjà gérés par HMR)
        options.static = {
            watch: false
        };

        // Fichiers à surveiller pour déclencher le Live Reload
        options.watchFiles = {
            paths: ['src/**/*.php', 'templates/**/*'],
        };
    });
