<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/category' => [[['_route' => 'category_index', '_controller' => 'App\\Controller\\CategoryController::index'], null, ['GET' => 0], null, true, false, null]],
        '/category/create' => [[['_route' => 'category_create', '_controller' => 'App\\Controller\\CategoryController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/contact' => [[['_route' => 'contact_index', '_controller' => 'App\\Controller\\ContactController::index'], null, ['GET' => 0], null, true, false, null]],
        '/contact/create' => [[['_route' => 'contact_create', '_controller' => 'App\\Controller\\ContactController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/event' => [[['_route' => 'event_index', '_controller' => 'App\\Controller\\EventController::index'], null, ['GET' => 0], null, true, false, null]],
        '/event/create' => [[['_route' => 'event_create', '_controller' => 'App\\Controller\\EventController::create'], null, ['GET' => 0, 'POST' => 1], null, false, false, null]],
        '/home' => [[['_route' => 'home_page_index', '_controller' => 'App\\Controller\\HomePageController::index'], null, ['GET' => 0], null, true, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/c(?'
                    .'|ategory/(?'
                        .'|([1-9]\\d*)(*:195)'
                        .'|([1-9]\\d*)/edit(*:218)'
                        .'|([1-9]\\d*)/delete(*:243)'
                    .')'
                    .'|ontact/(?'
                        .'|([1-9]\\d*)(*:272)'
                        .'|([1-9]\\d*)/edit(*:295)'
                        .'|([1-9]\\d*)/delete(*:320)'
                    .')'
                .')'
                .'|/event/(?'
                    .'|([1-9]\\d*)(*:350)'
                    .'|([1-9]\\d*)/edit(*:373)'
                    .'|([1-9]\\d*)/delete(*:398)'
                .')'
            .')/?$}sD',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        195 => [[['_route' => 'category_show', '_controller' => 'App\\Controller\\CategoryController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        218 => [[['_route' => 'category_edit', '_controller' => 'App\\Controller\\CategoryController::edit'], ['id'], ['GET' => 0, 'PUT' => 1], null, false, false, null]],
        243 => [[['_route' => 'category_delete', '_controller' => 'App\\Controller\\CategoryController::delete'], ['id'], ['GET' => 0, 'DELETE' => 1], null, false, false, null]],
        272 => [[['_route' => 'contact_show', '_controller' => 'App\\Controller\\ContactController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        295 => [[['_route' => 'contact_edit', '_controller' => 'App\\Controller\\ContactController::edit'], ['id'], ['GET' => 0, 'PUT' => 1], null, false, false, null]],
        320 => [[['_route' => 'contact_delete', '_controller' => 'App\\Controller\\ContactController::delete'], ['id'], ['GET' => 0, 'DELETE' => 1], null, false, false, null]],
        350 => [[['_route' => 'event_show', '_controller' => 'App\\Controller\\EventController::show'], ['id'], ['GET' => 0], null, false, true, null]],
        373 => [[['_route' => 'event_edit', '_controller' => 'App\\Controller\\EventController::edit'], ['id'], ['GET' => 0, 'PUT' => 1], null, false, false, null]],
        398 => [
            [['_route' => 'event_delete', '_controller' => 'App\\Controller\\EventController::delete'], ['id'], ['GET' => 0, 'DELETE' => 1], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
