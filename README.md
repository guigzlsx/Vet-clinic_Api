# **🐾 Vet Clinic API**

Bienvenue dans le projet **Vet Clinic API** ! Ce projet est une API pour gérer une clinique vétérinaire, construite avec Symfony et API Platform.

## **🚀 Fonctionnalités**

- **Gestion des utilisateurs** : Créez et gérez les utilisateurs avec différents rôles (Directeur, Vétérinaire, Assistant).
- **Gestion des animaux** : Ajoutez et gérez les animaux de la clinique.
- **Gestion des rendez-vous** : Planifiez et suivez les rendez-vous avec les vétérinaires et assistants.
- **Authentification JWT** : Sécurisez l'accès à l'API avec des tokens JWT.

## **👥 Membres du Groupe**

- [Le Saux Guillaume](https://github.com/guigzlsx)
- Pinau Lionel]*

## **🛠️ Installation**

1. Clonez le dépôt :
   ```sh
   git clone https://github.com/votre-utilisateur/vet-clinic-api.git
   cd vet-clinic-api
   ```
2. Installez les dépendances :
   ```sh
   composer install
   ```
3. Configurez les variables d'environnement :
   Copiez le fichier `.env` et modifiez les valeurs nécessaires :
   ```sh
   cp .env .env.local
   ```
4. Configurez votre .env pour la base de données et l'authentification JWT :
   ```bash
   # Configuration de la base de données
   DATABASE_URL="mysql://root:root@127.0.0.1:3306/lexik_api"
   # Configuration pour JWT (clé secrète)
   JWT_SECRET_KEY="votre_cle_secrète"
   ```
5. Générez les clés JWT :
   ```sh
   php bin/console lexik:jwt:generate-keypair
   ```
   Ou manuellement :
   ```sh
   mkdir -p config/jwt
   openssl genpkey -algorithm RSA -out config/jwt/private.pem -pkeyopt rsa_keygen_bits:4096
   openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
   ```
6. Créez la base de données et exécutez les migrations :
   ```sh
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

## **💻 Utilisation**

1. Lancez le serveur de développement :
   ```sh
   symfony server:start
   ```
   ou
   ```sh
   symfony serve
   ```
2. Accédez à l'API à l'adresse suivante :
   ```
   http://localhost:8000/api
   ```

## **📚 Documentation de l'API**

Une fois le serveur démarré, vous pouvez accéder à :

- Documentation interactive de l'API : `http://127.0.0.1:8000/api`
- Documentation Swagger : `http://localhost:8000/api/docs`

## **🔒 Sécurité**

L'authentification est gérée par le bundle LexikJWTAuthenticationBundle. Assurez-vous de configurer correctement les clés JWT et les variables d'environnement associées.

## **🧪 Tests**

Lancez les tests avec PHPUnit :

```sh
php bin/phpunit
```


---

Merci d'utiliser **Vet Clinic API** ! Si vous avez des questions ou des suggestions, n'hésitez pas à ouvrir une issue ou à me contacter. 🐶🐱
