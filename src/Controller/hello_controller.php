<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloController
{
    public function sayHello(): Response
    {
        $name = "you handsome!";

        return new Response(
            '<html><body>Hello! '.$name.'</body></html>'
        );
    }
}
