# Blog Professionnel

Réalisation d'un blog Professionnel dans le cadre d'un projet de formation de développeur d’application PHP/Symphony. 
Le projet utilise plusieurs librairies (*psr/http-message,zendframework/zend-diactoros ,http-interop/response-sender, 
zendframework/zend-httphandlerrunner, twig/twig*) intégrées grâce à Composer. Lors du développement les failles de 
sécurité (*XSS, CRSF, SQL injection, session hijacking*) ont été traitées. Le projet respect les normes PSR1, PSR2, PSR4, 
PSR7 et son architecture est basée sur le modèle MVC.

### Prérequis

Pour pouvoir utiliser le projet vous aurez besoin de :

* [Mysql]
* [PHP >7.0]

### Installation

Pour commencer placez vous dans le répertoire des sites de votre serveur web.


Télécharger le dossier du projet en faisant un :
```
git clone https://github.com/jeremybouvier/openclassrooms-projet5
```

Placez-vous dans le répertoire /Templates du projet :
```
cd openclassrooms-projet5/Templates/
```

Lancer votre serveur Mysql et créer le schéma de la base de donnée en utilisant le fichier databaseConstruct.sql :
```
mysql> source ~/openclassrooms-projet5/databaseConstruct.sql
```

## Consignes d’Exécution

Pour pouvoir visualiser le projet dans votre navigateur vous devez pour commencer lancer votre serveur php.

Placer vous dans le dossier du projet /openclassrooms-projet5 puis faites :
```
php -S localhost:8070
```

Lancer votre navigateur et saisissez ceci dans la barre d'adresse :
```
localhost:8070/home
```

Vous aurez alors accès au blog. 
Pour vous connectez à la partie administration utiliser le compte administrateur déjà définit dans le projet. 

*Compte administrateur :*

    login : admin
    Mot de passe : admin
    
## Développé avec

* **PHP 7.3.3**
* **HTML5 & CSS**
* **Mysql**
* **Composer** 

## Versioning

Le versioning du projet a été effectuer avec git version 2.7.4 , pour chaque étape du développement une branche a 
été créé et finalisé par un Pullrequest.


## Auteur

**Bouvier Jérémy** - Étudiant à Openclassrooms 
 Parcours suivi *Développeur d'application PHP/Symfony*

## Licence

Pas de licence enregistrer.



