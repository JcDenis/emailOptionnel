// -- BEGIN LICENSE BLOCK ----------------------------------
// This file is part of Email Optionnel, a plugin for Dotclear.
//
// Copyright (c) 2007-2020 Oleksandr Syenchuk, Pierre Van Glabeke, Gvx
//
// Licensed under the GPL version 2.0 license.
// A copy is available in LICENSE file or at
// http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
// -- END LICENSE BLOCK ------------------------------------

'use strict'

document.addEventListener("DOMContentLoaded", function() {
	var id_mail = 'c_mail', el = document.getElementById(id_mail);
	if(el) { el.removeAttribute('required'); }
});
