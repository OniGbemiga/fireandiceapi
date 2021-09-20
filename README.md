# Make a Call to [iceandfire](https://anapioficeandfire.com/) API and Perform a CRUD Request with Laravel and Vue 

This is a demo app showing how to make a call to an external api using laravel and how to perform a simple crud request using laravel and vue.

## Getting Started
The instructions below will guide you on how to install the project on your machine and run it smoothly.

### Prerequisites
What things you need to install the software.
- Git.
- PHP.
- Composer.
- Laravel CLI.
- A webserver like Nginx or Apache.
- A Node Package Manager ( npm or yarn ).

## Installation

Clone the git repository on your computer

```bash
$ git clone https://github.com/OniGbemiga/fireandiceapi.git
```
You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies.

```bash
$ cd fireandiceapi
$ composer install
```

## Setup

- When you are done with installation, copy the ``` .env.example``` file to ```.env```

``` $ cp .env.example .env ```

- Generate the application key

``` $ php artisan key:generate ```

- Add your database credentials to the necessary env fields

- Migrate the application

````$ php artisan migrate````

- Install node modules

```$ npm install```

## Run the application
```$ php artisan serve ```
