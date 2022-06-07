<?php
/**
 * Файл со специфическими настройками для Onessa5
 */
return [
        App\Models\User::class => '\\Onessa5\\Onessa5Core\\Admin\\Http\\Sections\\SUsers',
        App\Models\Role::class => '\\Onessa5\\Onessa5Core\\Admin\\Http\\Sections\\SRoles',
        \Onessa5\Onessa5Core\Models\SiteSetting::class => \App\Admin\Http\Sections\SSettings::class,
        \Onessa5\Onessa5Core\Models\SiteLayout::class => \Onessa5\Onessa5Core\Admin\Http\Sections\SSiteLayouts::class,

        \Onessa5\Onessa5Core\Models\Page::class => '\\Onessa5\\Onessa5Core\\Admin\\Http\\Sections\\SPages',
        \Onessa5\Onessa5Core\Models\PageTree::class => '\\Onessa5\\Onessa5Core\\Admin\\Http\\Sections\\SPageTree',
];

