<?php

/**
	Theme helpers functions
*/


// Url helpers
function full_url($url = '') {
	return '//' . $_SERVER['HTTP_HOST'] . Uri::to($url);
}

function base_url($url = '') {
    return Uri::to($url);
}

function theme_url($file = '') {
	return asset('themes/' . Config::get('meta.theme') . '/' . ltrim($file, '/'));
}

function theme_include($file) {
	if(is_readable($path = PATH . 'themes' . DS . Config::get('meta.theme') . DS . ltrim($file, '/') . '.php')) {
		return require $path;
	}
}

function asset_url($extra = '') {
	return asset('anchor/views/assets/' . ltrim($extra, '/'));
}

function current_url() {
	return Uri::current();
}

function search_url() {
	return base_url('search');
}

function rss_url() {
    return base_url('feeds/rss');
}

//  Custom function helpers
function bind($page, $fn) {
	Events::bind($page, $fn);
}

function receive($name = '') {
	return Events::call($name);
}

function body_class() {
	$classes = array();

	//  Get the URL slug
	$parts = explode('/', Uri::current());
	$classes[] = count($parts) ? trim(current($parts)) : 'index';

	//  Is it a posts page?
	if(is_postspage()) $classes[] = 'posts';

	//  Is it the homepage?
	if(is_homepage()) $classes[] = 'home';

	return implode(' ', $classes);
}

// page type helpers
function is_homepage() {
	if($itm = Registry::get('page')) {
		return isset($itm->id) and $itm->id == Config::meta('home_page');
	}

	return false;
}

function is_postspage() {
	if($itm = Registry::get('page')) {
		return isset($itm->id) and $itm->id == Config::meta('posts_page');
	}

	return false;
}