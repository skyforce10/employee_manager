employee manager application

1# create laravel 8.x project employee_manager

2# install laravel ui for authentication

3# install bootstrap 4

4# use php tinker to create database:
   php artisan tinker --execute="(new PDO('mysql:host=' . env('DB_HOST'), env('DB_USERNAME'), 
   env('DB_PASSWORD')))->exec('CREATE DATABASE ' . env('DB_DATABASE'))"

5# create table migration and seed fake data:
   php artisan migrate
   php artisan db:seed

4# Login->auth()->role->admin->(all forms)
   Login->auth()->role->user->(company list, company statistic, employee list/manage(without delete))

5# company list (edit,delete)

6# employee list (edit,delete)

7# Send email notification
    Mail::to('mohamed.el.dakdouki@gmail.com')->send(new CompanyCreated($company));
    this function is disabled due to google mail credential