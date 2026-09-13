<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Component Locations
    |---------------------------------------------------------------------------
    |
    | The directories Livewire searches when resolving single-file and
    | multi-file components by name.
    |
    */

    'component_locations' => [
        resource_path('views/components'),
        resource_path('views/livewire'),
    ],

    /*
    |---------------------------------------------------------------------------
    | Component Namespaces
    |---------------------------------------------------------------------------
    |
    | View based component namespaces, for example "layouts::app" resolves to
    | resources/views/layouts/app.blade.php.
    |
    */

    'component_namespaces' => [
        'layouts' => resource_path('views/layouts'),
        'pages' => resource_path('views/pages'),
    ],

    /*
    |---------------------------------------------------------------------------
    | Layout
    |---------------------------------------------------------------------------
    |
    | The view used as the layout when rendering a full-page component.
    |
    */

    'component_layout' => 'layouts::app',

    /*
    |---------------------------------------------------------------------------
    | Lazy Loading Placeholder
    |---------------------------------------------------------------------------
    |
    | The default placeholder view rendered for lazy loaded components before
    | they are resolved.
    |
    */

    'component_placeholder' => null, // Example: 'placeholders::skeleton'

    /*
    |---------------------------------------------------------------------------
    | Make Command
    |---------------------------------------------------------------------------
    |
    | Defaults used by "make:livewire". Type options: 'sfc', 'mfc', 'class'.
    |
    */

    'make_command' => [
        'type' => 'class',
        'emoji' => true,
        'with' => [
            'js' => false,
            'css' => false,
            'test' => false,
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Class Namespace
    |---------------------------------------------------------------------------
    */

    'class_namespace' => 'App\\Livewire',

    'class_path' => app_path('Livewire'),

    /*
    |---------------------------------------------------------------------------
    | View Path
    |---------------------------------------------------------------------------
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |---------------------------------------------------------------------------
    | Temporary File Uploads
    |---------------------------------------------------------------------------
    */

    'temporary_file_upload' => [
        'disk' => env('LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK'), // Example: 'local', 's3'             | Default: 'default'
        'rules' => null,                                      // Example: ['file', 'mimes:png,jpg'] | Default: ['required', 'file', 'max:12288'] (12MB)
        'directory' => null,                                  // Example: 'tmp'                     | Default: 'livewire-tmp'
        'middleware' => null,                                 // Example: 'throttle:5,1'            | Default: 'throttle:60,1'
        'preview_mimes' => [                                  // Supported file types for temporary pre-signed file URLs...
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // Max duration (in minutes) before an upload is invalidated...
        'cleanup' => true, // Should cleanup temporary uploads older than 24 hrs...
    ],

    /*
    |---------------------------------------------------------------------------
    | Render On Redirect
    |---------------------------------------------------------------------------
    */

    'render_on_redirect' => false,

    /*
    |---------------------------------------------------------------------------
    | Legacy Model Binding
    |---------------------------------------------------------------------------
    */

    'legacy_model_binding' => false,

    /*
    |---------------------------------------------------------------------------
    | Auto-inject Frontend Assets
    |---------------------------------------------------------------------------
    */

    'inject_assets' => true,

    /*
    |---------------------------------------------------------------------------
    | Navigate (SPA mode)
    |---------------------------------------------------------------------------
    */

    'navigate' => [
        'show_progress_bar' => true,
        'progress_bar_color' => '#2299dd',
    ],

    /*
    |---------------------------------------------------------------------------
    | HTML Morph Markers
    |---------------------------------------------------------------------------
    */

    'inject_morph_markers' => true,

    /*
    |---------------------------------------------------------------------------
    | Smart wire:key
    |---------------------------------------------------------------------------
    */

    'smart_wire_keys' => true,

    /*
    |---------------------------------------------------------------------------
    | Pagination Theme
    |---------------------------------------------------------------------------
    */

    'pagination_theme' => 'tailwind',

    /*
    |---------------------------------------------------------------------------
    | Release Token
    |---------------------------------------------------------------------------
    */

    'release_token' => 'a',

    /*
    |---------------------------------------------------------------------------
    | CSP Safe Mode
    |---------------------------------------------------------------------------
    */

    'csp_safe' => false,

    /*
    |---------------------------------------------------------------------------
    | Payload Limits
    |---------------------------------------------------------------------------
    */

    'payload' => [
        'max_size' => 1024 * 1024,   // 1MB - maximum request payload size in bytes
        'max_nesting_depth' => 10,   // Maximum depth of dot-notation property paths
        'max_calls' => 50,           // Maximum method calls per request
        'max_components' => 200,     // Maximum components per batch request
    ],

];
