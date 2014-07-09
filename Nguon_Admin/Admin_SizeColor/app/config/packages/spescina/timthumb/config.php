<?php

return array(
    'prefix' => 'pubweb.vn',
    'debug_on' => false,
    'debug_level' => 3,
    'file_cache_enabled' => true,
    'file_cache_directory' => app_path() . '/storage/cache/timthumb',
    'not_found_image' => asset('backend/images/nophoto.gif'),
    'error_image' => asset('backend/images/nophoto.gif'),
    'png_is_transparent' => true
);
