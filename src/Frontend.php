<?php
/**
 * @brief emailOptionnel, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors
 *
 * @copyright Jean-Crhistian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return null;
}

dcCore::app()->addBehavior('publicPrependV2', function () {
    dcCore::app()->blog->settings->addNamespace(initEmailOptionnel::SETTING_NAME);

    if (!isset($_POST['c_content'])
     || !empty($_POST['preview'])
     || !empty($_POST['c_mail'])
     || !dcCore::app()->blog->settings->get(initEmailOptionnel::SETTING_NAME)->enabled
    ) {
        return;
    }
    $_POST['c_mail'] = initEmailOptionnel::DEFAULT_EMAIL;
});

dcCore::app()->addBehavior('publicBeforeCommentCreate', function ($cur) {
    dcCore::app()->blog->settings->addNamespace(initEmailOptionnel::SETTING_NAME);

    if (dcCore::app()->blog->settings->get(initEmailOptionnel::SETTING_NAME)->enabled
     && $cur->comment_email == initEmailOptionnel::DEFAULT_EMAIL
    ) {
        # désactive l'affichage du mail dans le template
        dcCore::app()->ctx->comment_preview['mail'] = '';
        # n'enregistre pas de mail dans la BDD
        $cur->comment_email = '';
        # n'enregistre pas le mail dans le cookie
        if (empty($_POST['c_remember'])) {
            return;
        }
        if (!empty($_COOKIE['comment_info'])) {
            $cookie_info = explode("\n", $_COOKIE['comment_info']);
            if (count($cookie_info) == 3) {
                return;
            }
        }
        $c_cookie = ['name' => $cur->comment_author, 'mail' => $cur->comment_email, 'site' => $cur->comment_site];
        $c_cookie = serialize($c_cookie);
        setcookie('comment_info', $c_cookie, strtotime('+3 month'), '/');
    }
});

dcCore::app()->addBehavior('publicHeadContent', function () {
    dcCore::app()->blog->settings->addNamespace(initEmailOptionnel::SETTING_NAME);

    if (dcCore::app()->blog->settings->get(initEmailOptionnel::SETTING_NAME)->enabled) {
        echo dcUtils::jsLoad(
            dcCore::app()->blog->getPF(basename(__DIR__) . '/public.js'),
            dcCore::app()->plugins->moduleInfo(basename(__DIR__), 'version')
        );
    }
});
