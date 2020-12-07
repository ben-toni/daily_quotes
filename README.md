# **Cited**

Copy .env.example to .env

Setup data in .env and create db. You will see the indications in the file.

___

##### _Commands to run:_

`composer install`

`npm install`

`php artisan migrate:refresh --seed`

`php artisan key:generate`

`npm run dev`

`php artisan queue:work --queue=default,emails`

To test command for quote delivery run -> `php artisan send:quote`

___


Go to url `{base_url}/login` to access to login page.

Test account:

Email: `admin@demo.com`

Password: `@123qwer`

