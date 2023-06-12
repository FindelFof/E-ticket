
## Instruction d'installation API E-Ticket

-Etape 1 :
Clonez le référentiel GitHub : https://github.com/FindelFof/E-ticket.git.  

-Etape 2 :  
Naviguez dans le répertoire de votre projet : cd E-ticket. 

-Etape 3 :  
Installez les dépendances du projet en utilisant Composer : composer install --optimize-autoloader --no-dev  

-Etape 4 :  
Créez le fichier d'environnement .env : soit par console :cp .env.example .env ou creer un fichier .env  
executé la syntaxe : php artisan jwt:secret

-Etape 5 :   
Générez une nouvelle clé d'application : php artisan key:generate  

-Etape 6 :  
Assuez vous d'avoir déjà créer la base de données postgres.  
Configurer le fichier .env avec postgres :      
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=e-ticket
DB_USERNAME=postgres
DB_PASSWORD=postgres

-Etape 7 :  
Effectuer la migration : php artisan migrate:refresh --seed.

-Etape 8 :  
Lancer votre projet avec :php artisan serve

-Etape 9 :  
Génerer la doc Swagger avec : php artisan l5-swagger:generate  
Lancer l'URL de la documentation :http://127.0.0.1:8000/api/documentation.


N'hesitez pas à me contacter en cas de besoin : https://api.whatsapp.com/send?phone=+2250101561365

