<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of Email Optionnel, a plugin for Dotclear.
#
# Copyright (c) 2007-2015 Oleksandr Syenchuk, Pierre Van Glabeke
#
# Licensed under the GPL version 2.0 license.
# A copy is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------
if (!defined('DC_RC_PATH')) { return; }

# WARNING :
# Email Optionnel is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

$this->registerModule(
	/* Name */		'emailOptionnel',
	/* Description*/	'Make e-mail address optional in comments',
	/* Author */		'Oleksandr Syenchuk, Pierre Van Glabeke',
	/* Version */		'0.4.6',
	/* Properties */
	array(
		'permissions' => 'admin',
		'type' => 'plugin',
		'dc_min' => '2.6',
		'support' => 'http://forum.dotclear.org/viewtopic.php?pid=332948#p332948',
		'details' => 'http://plugins.dotaddict.org/dc2/details/emailOptionnel'
	)
);