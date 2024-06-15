## About Seatfinder

<p>Seatfinder is a small laravel application that is meant to try out programming logic to be able to seat persons in a cinema based on some objectives.</p>

<p>You can use seatfinder in two ways, the first way is to select a screen in the cinema using the first dropdown box. After this selection input a number of wanted tickets in the last input field. Random Screens and Seats can be seeded to the databse using the command "php artisan db:seed".</p>

<p>The second way is to input a number of seats available in the cinema, then input a percentage of seats that are already taken, and last fill in the number of wanted tickets.</p>

<p>Using these parameters the application decides what the best places are to sit in the cinema with a couple of rules:</p>

<ul>
    <li>First return null or nothing when there is not enough seats left in the cinema</li>
    <li>Second when there are enough seats to be able to sit next to each other return these seat numbers</li>
    <li>Third when there are not enough seats left to be able to sit next to each other split the group and return seat numbers untill everyone has a seat number</li>
</ul>

## Setup

<p>Seatfinder makes use of laravel in combination with vue. Vue has been installed using the laravel breeze package, this package was a bit overkill for this small application <br>
but was the easiest way to be able to install vue into laravel.</p>

<p>To be able to get this application running locally you need to follow these steps:</p>

<ol>
    <li>Create a new .env file based on the .env.example, the only values that need to be filled are the database values where Necessary is filled in as a comment.</li>
    <li>run "composer install" </li>
    <li>run "php artisan migrate" </li>
    <li>run "php artisan db:seed"</li>
    <li>run "php artisan serve" </li>
    <li>run "npm run dev" </li>
    <li>Using the URL given by the command "php artisan serve" you can browse to the application in your preferred browser.</li>
</ol>

