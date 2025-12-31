<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home Page']);
}

Route::get('about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/posts', function () {
    return view('posts', ['title' => 'Blog', 'posts' =>[
        [
            'title'=>'1001 Cara Menjadi Sigma',
            'author'=>'Rusdy',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vitae augue vel dolor feugiat iaculis. Nunc purus lectus, malesuada ac lacinia eu, tincidunt quis odio. Vivamus bibendum enim et pretium consequat. Vivamus laoreet dapibus tortor ut accumsan. Aenean congue, diam sed accumsan cursus, sapien velit blandit lorem, consectetur elementum lectus enim eu neque. Cras aliquet finibus ex vel feugiat. Nulla sodales dui metus, ut gravida odio posuere sed. Curabitur malesuada, nisl quis facilisis mattis, massa ex aliquam odio, eget dapibus urna nisl sit amet mi. Nunc nisi risus, mollis in massa vel, tincidunt porttitor ex. Praesent efficitur varius ipsum non vehicula. Nam purus turpis, aliquam in varius laoreet, dapibus et elit. Ut congue quis risus sed cursus. Praesent rhoncus laoreet dui, ac condimentum magna aliquam sit amet. Maecenas in lectus a nibh suscipit tristique. Duis hendrerit, risus et efficitur condimentum, justo nisl cursus odio, in euismod ante massa sed elit.'
        ],
        [
            'title'=>'1001 Cara Menjadi Alpha Male',
            'author'=>'Rusdy Sinaga',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vitae augue vel dolor feugiat iaculis. Nunc purus lectus, malesuada ac lacinia eu, tincidunt quis odio. Vivamus bibendum enim et pretium consequat. Vivamus laoreet dapibus tortor ut accumsan. Aenean congue, diam sed accumsan cursus, sapien velit blandit lorem, consectetur elementum lectus enim eu neque. Cras aliquet finibus ex vel feugiat. Nulla sodales dui metus, ut gravida odio posuere sed. Curabitur malesuada, nisl quis facilisis mattis, massa ex aliquam odio, eget dapibus urna nisl sit amet mi. Nunc nisi risus, mollis in massa vel, tincidunt porttitor ex. Praesent efficitur varius ipsum non vehicula. Nam purus turpis, aliquam in varius laoreet, dapibus et elit. Ut congue quis risus sed cursus. Praesent rhoncus laoreet dui, ac condimentum magna aliquam sit amet. Maecenas in lectus a nibh suscipit tristique. Duis hendrerit, risus et efficitur condimentum, justo nisl cursus odio, in euismod ante massa sed elit.'
        ],
    ]]);
}); 
Route::get('contact', function () {
    return view('contact', ['title'=>'Contact']);
});

