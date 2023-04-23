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

use ArrayObject;
use dcCore;
use dcNsProcess;
use dcUtils;
use Dotclear\Database\Cursor;

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
                // nullsafe PHP < 8.0
                if (is_null(dcCore::app()->blog)) {
                    return;
                }

                if (!isset($_POST['c_content'])
                 || !empty($_POST['preview'])
                 || !empty($_POST['c_mail'])
                 || !dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')
                ) {
                    return;
                }
                $_POST['c_mail'] = My::DEFAULT_EMAIL;
            },
            'publicBeforeCommentCreate' => function (Cursor $cur): void {
                // nullsafe PHP < 8.0
                if (is_null(dcCore::app()->blog) || is_null(dcCore::app()->ctx)) {
                    return;
                }

                if (dcCore::app()->blog->settings->get(My::SETTING_NAME)->get('enabled')
                 && $cur->getField('comment_email') == My::DEFAULT_EMAIL
                ) {
                    # désactive l'affichage du mail dans le template
                    $cp = dcCore::app()->ctx->__get('comment_preview');
                    if (is_a($cp, 'ArrayObject')) {
                        $cp = new ArrayObject([]);
                    }
                    $cp['mail'] = '';
                    dcCore::app()->ctx->__set('comment_preview', $cp);
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
            'publicHeadContent' => function (): void {
                // nullsafe PHP < 8.0
                if (is_null(dcCore::app()->blog)) {
                    return;
                }

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
