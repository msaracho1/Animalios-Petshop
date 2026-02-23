<?php
declare(strict_types=1);

use App\Core\Router;
use App\Core\Session;
use App\Core\Auth;

function route(string $name, $params = []): string {
    return Router::urlFor($name, is_array($params) ? $params : ['id' => $params]);
}

function session(string $key, $default = null) {
    return Session::getFlash($key) ?? Session::get($key, $default);
}

function auth() {
    return Auth::instance();
}

function old(string $key, $default = '') {
    $old = \App\Core\Session::get('_old', []);
    return $old[$key] ?? $default;
}

function request(string $key, $default = null) {
    return $_GET[$key] ?? $default;
}
