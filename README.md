# gastro-plus

## Umgebungvariablen 
um die Umgebungsvariablen zu nutzen ändere den namen von .env_example  in .env

## Routing 
To create routes in the project (currently only static), open the `app/config` folder, go to `routes.php`, and extend the array as desired.

```php
return [
    'about' => [
        'pattern' => '/about/miao',
        'method' => 'GET',
        'action' => 'home@index', // controller@action
        'middleware' => ['auth'],
    ],
    // Add more routes here
];
```

## Views
....
