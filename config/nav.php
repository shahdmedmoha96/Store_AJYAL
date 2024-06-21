<?php

return [
    [
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=>'dashboard',
        'title'=>'Starter Pages',
        'active'=>'dashboard'
        ],
[
'icon'=>'far fa-circle nav-icon',
'route'=>'categories.index',
'title'=>'Categories',
'active'=>['categories.index','categories.create','categories.edit','categories.show'],
],
[
    'icon'=>'far fa-circle nav-icon',
    'route'=>'products.index',
    'title'=>'Products',
    'active'=>['products.index','products.create','products.edit'],
    'badge'=>'New'
    ],

];
