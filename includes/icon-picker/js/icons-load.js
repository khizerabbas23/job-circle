var icons_load_call;
var loaded_icons;
jQuery(document).ready(function ($) {
    'use strict';
    var plugin_url = jobcircle_icons_vars.plugin_url;

    icons_load_call = $.getJSON(plugin_url + "includes/icon-picker/js/selection.json?ver=" + jobcircle_icons_vars.version)
    .done(function (response) {
        loaded_icons = response;
    });
});