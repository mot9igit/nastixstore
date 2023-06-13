<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/nastixstore/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/nastixstore')) {
            $cache->deleteTree(
                $dev . 'assets/components/nastixstore/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/nastixstore/', $dev . 'assets/components/nastixstore');
        }
        if (!is_link($dev . 'core/components/nastixstore')) {
            $cache->deleteTree(
                $dev . 'core/components/nastixstore/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/nastixstore/', $dev . 'core/components/nastixstore');
        }
    }
}

return true;