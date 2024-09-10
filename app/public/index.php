<?php
require_once __DIR__ . '/../vendor/autoload.php';

use RedBeanPHP\R;
use Mod\Crm\Controllers\UserController;
use League\Plates\Engine;
use Mod\Crm\Actions\MakeUserTableAction;

R::setup('mysql:host=mysql_crm;dbname=crm_db', 'crm_user', 'crm_123456789');

$router = new AltoRouter();
$templates = new Engine(__DIR__ . '/../views');

MakeUserTableAction::handler();
$userController = new UserController();

// API routes
$router->map('GET', '/api/user/', function() use ($userController) {
    echo '<pre>' . print_r($_SERVER, true) . '</pre>';
});
$router->map('POST', '/api/user/', function() use ($userController) {
    echo $userController->store();
});
$router->map('PUT', '/api/user/[i:id]', function($id) use ($userController) {
    echo $userController->update($id);
});
$router->map('DELETE', '/api/user/[i:id]', function($id) use ($userController) {
    $code = ($userController->delete($id)) ? '200' : '404';
    echo '{"status": ' . $code . '}';
});

// Other routes
$router->map('GET', '/', function() use($templates) {
    echo $templates->render('main', ['type' => 'add']);
});

$router->map('GET', '/users', function() use($templates, $userController) {
    echo $templates->render('main', ['users' => $userController->index()]);
});

// Handle routes
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // If no route is matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    echo 'Page not found!';
}
