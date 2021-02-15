# formation dev fullstack

    https://github.com/form2021/formation

## liveshare

    lundi 15/02

https://prod.liveshare.vsengsaas.visualstudio.com/join?B41D3B9E942814ABD44E222C1CE311B08097


## GESTION DES UTILISATEURS ET SECURITE DANS SYMFONY

    https://symfony.com/doc/current/security.html

    https://symfony.com/doc/current/security.html#a-create-your-user-class

    LANCER DANS LE TERMINAL (DANS LE DOSSIER symfony/)

    php bin/console make:user




```
    php bin/console make:user

    The name of the security user class (e.g. User) [User]:
    > User

    Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
    > yes

    Enter a property name that will be the unique "display" name for the user (e.g.
    email, username, uuid [email]
    > email

    Does this app need to hash/check user passwords? (yes/no) [yes]:
    > yes

    created: src/Entity/User.php
    created: src/Repository/UserRepository.php
    updated: src/Entity/User.php
    updated: config/packages/security.yaml
```



    ON A UNE BASE DE CODE POUR L'ENTITE User
    MAIS IL MANQUE DES PROPRIETES

    email           string(255)      VARCHAR(255)
    dateCreation    datetime         DATETIME
    ...  

    LANCER LA COMMANDE POUR COMPLETER LES PROPRIETES...
    
    php bin/console make:entity




    SE POSER DES QUESTIONS SUR LE RGPD ET LA LEGALITE DES INFOS SUR LES UTILISATEURS...

    * CONNECTER NOTRE ENTITE AVEC LE SYSTEME DE SECURITE DE SYMFONY

    https://symfony.com/doc/current/security/form_login_setup.html#generating-the-login-form




```
     php bin/console make:auth

    What style of authentication do you want? [Empty authenticator]:
    [0] Empty authenticator
    [1] Login form authenticator
    > 1

    The class name of the authenticator to create (e.g. AppCustomAuthenticator):
    > LoginFormAuthenticator

    Choose a name for the controller class (e.g. SecurityController) [SecurityController]:
    > SecurityController

    Do you want to generate a '/logout' URL? (yes/no) [yes]:
    > yes

    created: src/Security/LoginFormAuthenticator.php
    updated: config/packages/security.yaml
    created: src/Controller/SecurityController.php
    created: templates/security/login.html.twig
```



    * ON VA LANCER LA COMMANDE POUR LA L'INSCRIPTION DE L'UTILISATEUR

    php bin/console make:registration-form

    CA VA GENERER LE CODE...
    https://symfonycasts.com/screencast/symfony-forms/registration-form

    LE SITE A CASSE CAR IL ME MANQUE UN BUNDLE POUR L'ENVOI D'EMAIL DE CONFIRMATION

    DANS LE TERMINAL (ET DANS LE DOSSIER syfmony/)

    composer require symfonycasts/verify-email-bundle




    SI ON ESSAIE D'ALLER SUR LA PAGE /register POUR CREER UN COMPTE
    ON A UNE ERREUR SUR LA CONFIG MAILER_DSN

    https://symfony.com/doc/current/mailer.html

    => modification du fichier .env



    LA PAGE /register S'AFFICHE MAIS ON N'A PAS LA TABLE SQL

    => on la crée avec : 
    php bin/console make:migration

    php bin/console doctrine:migrations:migrate