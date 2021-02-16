# formation dev fullstack

    https://github.com/form2021/formation

## liveshare

    mardi 16/02

https://prod.liveshare.vsengsaas.visualstudio.com/join?1385DE286D62F362A671381C52D65BAED945


## EXERCICE

    ## PROJET POUR LA SEMAINE


    SITE DE PETITES ANNONCES

    UN VISITEUR PEUT CREER UN COMPTE
    ENSUITE IL PEUT SE CONNECTER
    ET UNE FOIS CONNECTE, IL A ACCES A UN ESPACE MEMBRE
    DANS SON ESPACE MEMBRE, 
        IL PEUT CREER DES ANNONCES
        IL NE PEUT VOIR QUE SES ANNONCES
        IL NE PEUT MODIFIER QUE SES ANNONCES
        IL NE PEUT SUPPRIMER QUE SES ANNONCES

        RELATION ONE TO MANY ENTRE User ET Annonce
        (UNE ANNONCE EST CREEE PAR UN USER)
        (UN USER PEUT CREER PLUSIEURS ANNONCES)

        RELATION MANY TO MANY ENTRE Annonce ET Categorie
        UNE ANNONCE PEUT ETRE CLASSEE DANS PLUSIEURS CATEGORIES
        UNE CATEGORIE PEUT CONTENIR PLUSIEURS ANNONCES

    SUR LA PARTIE PUBLIQUE
        AJOUTER UNE PAGE QUI AFFICHE TOUTES LES ANNONCES
        ET CHAQUE ANNONCE A SA PROPRE PAGE

        AJOUTER UN MOTEUR DE RECHERCHE 
            POUR CHERCHER LES ANNONCES QUI CONTIENNENT UN MOT CLE

    DANS LA PARTIE ADMIN    (make:crud et compléter...)
        AJOUTER LA GESTION 
        DE TOUS LES USERS
        DE TOUS LES ANNONCES
        DE TOUTES LES CATEGORIES
        ...


CREER LES ENTITES ET LE CRUD (make:entity ET make:crud)
## ENTITE Categorie

    id
    label
    description

## ENTITE Annonce

    id
    titre
    slug
    contenu
    image
    datePublication
    
    UNE FOIS LE make:crud FAIT
    ON PEUT CREER DES ANNONCES DANS LA PARTIE /admin/annonce

    * AJOUTER DANS LA PARTIE PUBLIQUE UNE PAGE /annonces
        QUI VA AFFICHER LES ANNONCES POUR LES VISITEURS 

    RAJOUTER LES RELATIONS DANS UN 2E TEMPS
    user_id     => ONE TO MANY (relation avec User)

## AJOUT DE RELATIONS ENTRE ENTITES

    LANCER LA COMMANDE make:entity
    ET CREER UNE PROPRIETE
    ET CHOISIR COMME TYPE relation
    REPONDRE AUX QUESTIONS...

## TWIG POUR AFFICHER UN MENU DIFFERENT SI LE VISITEUR EST CONNECTE

    DANS TWIG SYMFONY CREE UNE VARIABLE app 
    QU'ON PEUT UTILISER POUR RETROUVER L'UTILISATEUR CONNECTE
    
```twig

        {% if app.user %}
            <div class="mb-3">
                Bienvenue {{ app.user.username }}, <a href="{{ path('app_logout') }}">Déconnexion</a>
            </div>
        {% else %}
            <nav>
                <a href="{{ path('app_register') }}">créez votre compte</a>
                <a href="{{ path('app_login') }}">connexion</a>
            </nav>
        {% endif %}

```