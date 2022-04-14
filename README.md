# Subscriber Management
<p align="center"><a href="https://laravel.com" target="_blank">
<img src="./github/laravel.svg" width="80"></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://vuejs.org" target="_blank" rel="noopener noreferrer"><img width="85" src="./github/vuejs.png" alt="Vue logo"></a>
<a href="https://tailwindcss.com/" target="_blank">
      <img alt="Tailwind CSS" width="120" src="./github/tailwindcss.svg">
    </a>
</p>

## Functionalities

 - [x] Custom fields CRUD.
 - [x] Subscriber CRUD.
 - [x] Each subscriber can have more data in custom created fields. (subscribers and fields relationship)
 - [x] Unit test of each features.
 - [x] Subscriber list view with column toggle.
 - [x] Developed using Laravel (as backend api) + VueJs (as frontend ui) + TailwindCSS (as ui framework)

## Demo
**Visit for Demo** ---> [https://submanage.ashrafulislam.info](https://submanage.ashrafulislam.info)

## Local Installation
Clone the repository in your local machine using `git clone https://github.com/ashraful19/subscriber-management`

### *Requirements* for Local Environment

 - [x] PHP Version 8.0
 - [x] NodeJs Version 14 (Have tested on v14, but should be okay with v12 also)
 - [x] MySql version 5.7

> Before starting below points, please make sure your `8000` and `3000` ports are free. 
> On Mac if you have `valet` running please stop it using 'valet stop' before going forward

### Running Backend API
 1. Open terminal/command promt from inside the `subscriber-management/backend` folder
 2. run command `cp .env.example .env`
 3. update `.env` file database informations according to your local machine.
 4. run command `composer install`
 5. run command `php artisan migrate`
 6. run command `php artisan serve`

> At this point you have the backend application ready at `http://localhost:8000` to receive rest api calls from frontend ui

#### Running Unit Tests
7. Run command `php artisan test` to execute unit test cases

#### Populate database with dummy data
8. Run command `php artisan db:seed` to populate database with dummy data

### Running Frontend UI
 1. Open terminal/command promt from inside the `subscriber-management/frontend` folder
 2. run command `cp .env.example .env`
 3. run command `npm install`
 4. run command `npm run dev`

> At this point you have the frontend ui application ready
> ready to browse. Just open your browser and navigate to
> `http://localhost:3000` and you should see the Subscriber-Management site home page

## Features
> Below points may seem over-engineering for a project like this. Because project requirements were basic and size was small too. But the below points are done to keep the project highly extendable and to demonstrate the need or importance or usability of these in bigger projects.
 - Laravel part 
	 - API Resource as response
	 - Eloquent ORM and Relationship
	 - Seperate **Form Request** classes for each forms
     - Complete **Test Cases** for every feature
     - Seeder and Factory for populate dummy data
 - VueJs part
	 - **Reusable Component** based structure
	 - **Vue3 Composition API** used
 - Used **TailwindCSS** and **DaisyUI**

## Scope of Improvements
1. **User Authentication** can be provided to use this in a bigger scale. Currently the application is in a public/single scope sense.
2. Pagination in subscribers and field list


## To Do

 - [ ] Docker implementation
