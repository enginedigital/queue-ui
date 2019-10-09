<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    // what the prefix the route with
    'route_prefix' => 'queue',
    // apply this middleware to the route group
    'route_middleware' => 'web',
    // should the jobs be paginated
    'paginate' => true,
    'paginate_size' => 100,
    // which view to use
    'paginate_partial' => 'vendor.pagination.bootstrap-4',
    // any commands that are allow to be run from this page
    // these will be validated
    'command_whitelist' => [
        'view:clear' => [
            'label' => 'Clear View',
            'arguments' => '', // TODO
        ],
        'cache:clear' => [
            'label' => 'Clear Cache',
            'arguments' => '', // TODO
        ],
    ],
];
