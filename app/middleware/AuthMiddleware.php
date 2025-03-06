<?php

namespace App\Middleware;

class AuthMiddleware
{
    public function handle()
    {
        if (isset($_SESSION['user'])) {
            echo 'User is logged in.';
            return;
        } 
    }
}   