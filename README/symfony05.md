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

    * DOCUMENTATION UN PEU PLUS DETAILLEE SUR LES ETAPES AVEC make:entity
    https://symfony.com/doc/current/doctrine/associations.html

    LANCER LA COMMANDE make:entity
    ET CREER UNE PROPRIETE
    ET CHOISIR COMME TYPE relation
    REPONDRE AUX QUESTIONS...

```
    $ php bin/console make:entity

    Class name of the entity to create or update (e.g. BraveChef):
    > Product

    New property name (press <return> to stop adding fields):
    > category

    Field type (enter ? to see all types) [string]:
    > relation

    What class should this entity be related to?:
    > Category

    Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
    > ManyToOne

    Is the Product.category property allowed to be null (nullable)? (yes/no) [yes]:
    > no

    Do you want to add a new property to Category so that you can access/update
    Product objects from it - e.g. $category->getProducts()? (yes/no) [yes]:
    > yes

    New field name inside Category [products]:
    > products

    Do you want to automatically delete orphaned App\Entity\Product objects
    (orphanRemoval)? (yes/no) [no]:
    > no

    New property name (press <return> to stop adding fields):
    >
    (press enter again to finish)

```

## TWIG POUR AFFICHER UN MENU DIFFERENT SI LE VISITEUR EST CONNECTE

    * OBTENIR LES INFOS SUR LE USER CONNECTE
    https://symfony.com/doc/current/security.html#fetch-the-user-in-a-template

    * OBTENIR LES DROITS SUR LE USER CONNECTE
    https://symfony.com/doc/current/security.html#fetch-the-user-in-a-template

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

## OBTENIR LE USER CONNECTE DANS PHP

    https://symfony.com/doc/current/security.html#a-fetching-the-user-object

    https://symfony.com/doc/current/security.html#b-fetching-the-user-from-a-service

```php
// src/Service/ExampleService.php
// ...

use Symfony\Component\Security\Core\Security;

class ExampleService
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    public function someMethod()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
    }
}

```


## TESTS AUTOMATISES AVEC PHPUNIT

    * A DECOUVRIR: COMMENT CREER DES TESTS AUTOMATISES DANS SYMFONY AVEC PHPUNIT
    https://symfony.com/doc/current/testing.html#your-first-functional-test


## PROTEGER ESPACE MEMBRE

    AJOUTER UNE REGLE DANS LE FICHIER config/packages/security.yaml
    ET AUSSI METTRE A JOUR LA REDIRECTION DANS src/Security/LoginFormAuthenticator.php


```yaml
    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/membre, roles: ROLE_USER }


```

```php

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        // IL FAUT RECUPERER L'UTILISATEUR CONNECTE
        // ET SUIVANT LE ROLE DE L'UTILISATEUR, ON LE REDIRIGE VERS L'ESPACE ADMIN OU MEMBRE
        // https://symfony.com/doc/current/security.html#b-fetching-the-user-from-a-service
        // https://symfony.com/doc/current/security.html#hierarchical-roles
        // $userConnecte = $this->security->getUser();
        // BAD
        // $isAdmin = in_array("ROLE_ADMIN", $userConnecte->getRoles());

        // GOOD
        $nomRouteRedirection = "index";
        if ($this->security->isGranted("ROLE_ADMIN")) {
            // redirection vers la page /admin
            $nomRouteRedirection = "admin";
        }
        elseif ($this->security->isGranted("ROLE_USER")) {
            // redirection vers la page /membre
            $nomRouteRedirection = "membre";
        }

        // For example : 
        // TODO: CHANGER LA REDIRECTION VERS UNE PAGE ESPACE MEMBRE
        // POUR LE MOMENT, ON REDIRIGE VERS LA PAGE D'ACCUEIL...
        return new RedirectResponse($this->urlGenerator->generate($nomRouteRedirection));
        // throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }


```


## AJOUTER UNB FORMULAIRE POUR CREER UNE ANNONCE


    DANS LA PAGE D'ESPACE MEMBRE
    AJOUTER UN FORMULAIRE POUR PERMETTRE A UN MEMBRE DE PUBLIER UNE ANNONCE

    BONUS:
    CREER LA PAGE /annonces DANS LA PARTIE PUBLIQUE POUR LES VISITEURS
    ET AFFICHER LA LISTE DES ANNONCES DANS CETTE PAGE