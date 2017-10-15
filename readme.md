## Codave Blog

A very very very simple blogging platform powered by Laravel and VueJS integrated with Google Sign-in as main way of authentication. Goodbye registration form!


## Installation

#### 1.) Clone the repository

    git clone https://github.com/WisdomSky/coding-avenue.git
     
#### 2.) Go to the project directory

    cd coding-avenue
    
#### 3.) Install Composer and NPM dependencies

    composer install
    npm install
    

*NOTE: If you don't have composer and npm installed, you can go to the respectively links below for instructions on how to install them.*

Composer - [https://getcomposer.org/](https://getcomposer.org/)

NodeJS/NPM - [https://nodejs.org/en/](https://nodejs.org/en/)

#### 4.) Configure the `.env` file

At the root of the project directory, you will find a file `.env`, but if not, you can copy `.env.example` and name it to `.env`. 

You need to fill-in the **database credentials** in order for the application to work properly.

e.g

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=coding-avenue
    DB_USERNAME=root
    DB_PASSWORD=123456


You also need to supply your **Google API Client ID** in order for the google authentication to work properly.

e.g

    GOOGLE_CLIENT_ID=625475223201-dgf0349fsdf934fdst34560.apps.googleusercontent.com
    
*NOTE: Your Google API Project must have the Google+ API service enabled. You can follow these [instructions](https://developers.google.com/+/web/signin/#enable_the_google_api).* 
   
    
You might as well optionally update the `APP_NAME` and `APP_URL`.

#### 5.) Setting up the database

Create the necessary table structure by running this command

    php artisan migrate
    

Since the blog is using Google Sign-in for the authentication and we only want certain people to access the dashboard,
we need to specifically run the following command while passing the target **email address** which will allow the user to log-in using their google account if their email address matches any of the saved emails in the database which were added using the command below.

    php artisan signin:allow email_address [--role=writer]
    
e.g

    php artisan signin:allow johndoe@example.com
    
    
#### 6.) Running the application
 
 To run the application, we need to compile the application's assets atleast once using the command below:
 
    npm run prod
    
    
#### 7.) Start posting

To start posting, you can log-in into the dashboard by going to

    http://localhost/login
    
*NOTE: Replace `localhost` with the appropriate domain.*

    



## Testing

You can test the application with dummy posts using the command below:

    php artisan db:seed
    

*NOTE: This command will select the first user in the database, so before you start, you need to sign-in atleast once into the dashboard. This command will generate around 10,000 dummy posts for that selected user.*