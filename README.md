# lobbywars

--------- Pasos para instalar ----------

composer update

php bin/console doctrine:database:create  
php bin/console doctrine:schema:create  
bin/console doctrine:fixture:load
            
            TEST
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:create --env=test
bin/console doctrine:fixture:load  --env=test

----------------Levantar ---------------

php -S localhost:8000 -t public

----------------- Info -----------------

BD MYSQL 127.0.0.1 lawsuits  User: root  Pass: root  

