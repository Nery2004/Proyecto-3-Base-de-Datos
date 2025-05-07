<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Set some default values. It is possible to add all defines that can be set
    | in dompdf_config.inc.php. You can also override the entire config file.
    |
    */
    'show_warnings' => false,   // Mostrar advertencias del PDF
    'orientation'   => 'portrait',
    'defines'       => [
        /**
         * The root of your DOMPDF installation
         */
        "DOMPDF_DIR" => storage_path('dompdf'),

        /**
         * HTML to PDF rendering directory
         */
        "DOMPDF_TEMP_DIR" => sys_get_temp_dir(),

        /**
         * Allow remote access to images and stylesheets
         */
        "DOMPDF_ENABLE_REMOTE" => true,

        /**
         * Enable CSS float
         */
        "DOMPDF_ENABLE_CSS_FLOAT" => true,

        /**
         * Enable inline PHP
         */
        "DOMPDF_ENABLE_PHP" => false,

        /**
         * Enable inline Javascript
         */
        "DOMPDF_ENABLE_JAVASCRIPT" => true,

        /**
         * Enable remote file access
         */
        "DOMPDF_ENABLE_REMOTE" => true,

        /**
         * The paper size (default: "letter")
         */
        "DOMPDF_DEFAULT_PAPER_SIZE" => "a4",

        /**
         * Image DPI setting (for high-resolution images)
         */
        "DOMPDF_DPI" => 150,

        /**
         * Enable font subsetting
         */
        "DOMPDF_ENABLE_FONTSUBSETTING" => true,

        /**
         * Enable HTML5 parser
         */
        "DOMPDF_ENABLE_HTML5PARSER" => true,

        /**
         * Use Unicode fonts
         */
        "DOMPDF_UNICODE_ENABLED" => true,

        /**
         * Font cache directory
         */
        "DOMPDF_FONT_CACHE" => storage_path('fonts/'),

        /**
         * Font metrics cache directory
         */
        "DOMPDF_FONT_METRICS_CACHE" => storage_path('fonts/'),

        /**
         * Use the more-than-experimental HTML5 Lib parser
         */
        "DOMPDF_ENABLE_HTML5PARSER" => true,
    ],

];