<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'authFilter' => \App\Filters\AuthFilter::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'authFilter'  => ['except' => ['/', '/login', 'login/*']]
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],

        'after' => [
            //'toolbar',
            'authFilter'  => ['except' => ['/dashboard-sibamira', '/dashboard-sibamira/*', '/list-bmn-dashboard', '/list-bmn-dashboard/*', '/detail-bmn-dashboard', '/detail-bmn-dashboard/*', '/list-kki', '/detail-kki/*', '/import-kki', '/import-update-kki', '/hapus-batch/*', '/inv-pmnontik', '/inv-pmtik', '/inv-atb', '/inv-atl', '/kertas-kerja/*', '/report-rekapitulasi', '/report-inventarisasi', '/label', '/detail-label', 'APISatkerOnDashboard/*', '/isikertaskerja-add', '/detail-label/*', '/updateStatusLabel/*',  '/kelolaLevel', '/kelolaLevel/*', '/kelolaMenu', '/kelolaMenu/*', '/kelolaSubMenu', '/kelolaSubMenu/*',  '/updateMenu', '/updateSubmenu', '/saveMenu', '/savesubmenu', '/editKelolaLevel/*', '/updateKelolaLevel/*', '/saveLevel', '/updateNamaLevel', '/switchLevel', '/APIrekapitulasi/*', '/cetak-rekapitulasi', '/cetakInventarisasi', '/user', '/gedung', '/ruangan', '/satker']],
            // 'honeypot', 
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];
}
