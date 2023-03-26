<?php
/**
 * @brief emailOptionnel, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Oleksandr Syenchuk, Pierre Van Glabeke, Gvx and Contributors
 *
 * @copyright Jean-Christian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\emailOptionnel;

use cursor;
use dcCore;
use dcNsProcess;
use dcUtils;

class Frontend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_RC_PATH');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        dcCore::app()->addBehaviors([
            'publicPrependV2' => function (): void {
                if (!isset($_POST['c_content'])
                 || !empty($_POST['preview'])
                 || !empty($_POST['c_mail'])
                 || !dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')
                ) {
                    return;
                }
                $_POST['c_mail'] = My::DEFAULT_EMAIL;
            },
            'publicBeforeCommentCreate' => function (cursor $cur) {
                if (dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')
                 && $cur->getField('comment_email') == My::DEFAULT_EMAIL
                ) {
                    # désactive l'affichage du mail dans le template
                    dcCore::app()->ctx->comment_preview['mail'] = '';
                    # n'enregistre pas de mail dans la BDD
                    $cur->setField('comment_email', '');
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
                    $c_cookie = ['name' => $cur->getField('comment_author'), 'mail' => $cur->getField('comment_email'), 'site' => $cur->getField('comment_site')];
                    $c_cookie = serialize($c_cookie);
                    setcookie('comment_info', $c_cookie, strtotime('+3 month'), '/');
                }
            },
            'publicHeadContent' => function () {
                if (dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')) {
                    echo dcUtils::jsLoad(
                        dcCore::app()->blog->getPF(My::id() . '/js/frontend.js'),
                        dcCore::app()->plugins->moduleInfo(My::id(), 'version')
                    );
                }
            },
        ]);

        return true;
    }
}
