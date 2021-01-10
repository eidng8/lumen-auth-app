<?php

/*
 * GPLv3  https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 * author eidng8
 *
 */

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

$router->post('register', 'AuthController@register');
$router->post('login', 'AuthController@login');
$router->post('password/reset', 'AuthController@passwordReset');
$router->post('refresh', 'TokenController@refresh');
$router->post('logout', 'TokenController@logout');
