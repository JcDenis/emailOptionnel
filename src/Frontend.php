<?php

declare(strict_types=1);

namespace Dotclear\Plugin\emailOptionnel;

use ArrayObject;
use Dotclear\App;
use Dotclear\Core\Process;
use Dotclear\Database\Cursor;

/**
 * @brief       emailOptionnel frontend class.
 * @ingroup     emailOptionnel
 *
 * @author      Oleksandr Syenchuk (author)
 * @author      Jean-Christian Denis (latest)
 * @copyright   GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
class Frontend extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::FRONTEND));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        App::behavior()->addBehaviors([
            'publicPrependV2' => function (): void {
                if (!App::blog()->isDefined()) {
                    return;
                }

                if (!isset($_POST['c_content'])
                 || !empty($_POST['preview'])
                 || !empty($_POST['c_mail'])
                 || !My::settings()->get('enabled')
                ) {
                    return;
                }
                $_POST['c_mail'] = My::DEFAULT_EMAIL;
            },
            'publicBeforeCommentCreate' => function (Cursor $cur): void {
                if (!App::blog()->isDefined()) {
                    return;
                }

                if (My::settings()->get('enabled')
                 && $cur->getField('comment_email') == My::DEFAULT_EMAIL
                ) {
                    # désactive l'affichage du mail dans le template
                    $cp = App::frontend()->context()->__get('comment_preview');
                    if (is_a($cp, 'ArrayObject')) {
                        $cp = new ArrayObject([]);
                    }
                    $cp['mail'] = '';
                    App::frontend()->context()->__set('comment_preview', $cp);
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
                if (My::settings()->get('enabled')) {
                    echo My::jsLoad('frontend', App::plugins()->moduleInfo(My::id(), 'version'));
                }
            },
        ]);

        return true;
    }
}
