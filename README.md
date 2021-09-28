1. run composer install
2. change database name in env
3.  run db:seed admin
4. run db:seed webhook
5. laravel cmd for user list:
    php artisan user:user --operation=l
6. laravel cmd for user create:
    php artisan user:user --operation=c --email=123@gmail --name=123
7. laravel cmd for user delete:
    php artisan user:user --operation=d --id=2
8. laravel cmd for todo list:
    php artisan todo:list 
9. laravel cmd for todo list create by id:
    php artisan todo:list --id