<?php

function pdo_connect_mysql()
{

    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbrud";

    try {
        return new PDO('mysql:host=' . $serverName . ';dbname=' . $dbname . ';charset=utf8', $username, $password);
    } catch (PDOException $exception) {

        exit('Failed to connect to database!');
    }
}

function template_header($title)
{
    echo <<<EOT
        <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="myjs.js"></script>
        <title>$title</title>
    </head>

    <body>

        <div class="header-2 ">

            <nav class="bg-gray-300 py-2 md:py-4">
                <div class="container px-4 mx-auto md:flex md:items-center">

                    <div class="flex justify-between items-center">
                        <a href="#" class="font-bold text-xl text-indigo-600">WebSite title</a>
                        <button class="border border-solid border-gray-600 px-3 py-1 rounded text-gray-600 opacity-50 hover:opacity-75 md:hidden" id="navbar-toggle">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <div class="hidden md:flex flex-col md:flex-row md:ml-auto mt-3 md:mt-0" id="navbar-collapse">
                        <a href="index.php" class="p-2 lg:px-4 md:mx-2 text-white rounded bg-indigo-600"><i class="fas fa-home"></i> Home</a>

                        <a href="crud_action.php" class="p-2 lg:px-4 md:mx-2 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-700 transition-colors duration-300"><i class="fas fa-address-book"></i> Contact</a>
                    </div>
                </div>
            </nav>

        </div>
    EOT;
}

function template_footer(){
    echo <<<EOT
        </body>
    </html>
    EOT;
}


