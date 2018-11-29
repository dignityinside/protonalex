/**
 * @author Alexander Schilling
 * @package phpland/main
 */

var phpland = phpland || {};

phpland.main = (function($) {

    'use strict';

    return {

        init: function() {

            if (window.noAdBlock === undefined) {
                $('.author_support_hint').css('display', 'block');
            }

        }

    };

})($);


$(document).ready(function(){
    phpland.main.init();
});
