/**
 * Imgur uploader
 *
 * @author Alexander Schilling
 * @package app/imgur_uploader
 *
 */

var app = app || {};

app.imgur_uploader = (function($, ClipboardJS) {

    'use strict';

    var SELECTORS = {
        IMG_LIST: '#imgur_img_list',
        IMG_LIST_IMG: '#imgur_img_list img',
        IMG_UPLOAD_FIELD: '#imgur_img_upload_field',
        ADD_IMG: '#imgur_add_img'
    };

    window.ondragover = function (e) {
        e.preventDefault();
    };

    window.ondrop = function (e) {
        e.preventDefault();
        upload(e.dataTransfer.files[0]);
    };

    window.upload = function (file) {

        if (!file || !file.type.match(/image.*/)) {
            return;
        }

        var formData = new FormData();

        formData.append('image', file);

        var settings = {
            async: true,
            crossDomain: true,
            processData: false,
            contentType: false,
            type: 'POST',
            url: 'https://api.imgur.com/3/image.json',
            headers: {
                Authorization: 'Client-ID 63b93949b8e65a4', // change this id for you app
                Accept: 'application/json'
            },
            mimeType: 'multipart/form-data'
        };

        settings.data = formData;

        $.ajax(settings).done(function(response) {

            var imgurl = JSON.parse(response).data.link;
            $(SELECTORS.IMG_LIST).append('<img src="' + imgurl + '" />');

        });

    };

    /**
     * Copy img url to clipboard
     *
     * @param event
     */
    function copyImgUrlToClipboard(event) {

        var $element = $(event.currentTarget);

        var clipboard = new ClipboardJS(SELECTORS.IMG_LIST_IMG, {

            text: function () {
                return $element.attr('src');
            }

        });

    }

    return {

        init: function() {

            $(document).on('click', SELECTORS.IMG_LIST_IMG, copyImgUrlToClipboard);

            $(document).on('click', SELECTORS.ADD_IMG, function () {
                $(SELECTORS.IMG_UPLOAD_FIELD).click();
            });

            $(document).on('change', SELECTORS.IMG_UPLOAD_FIELD, function () {
                upload(this.files[0]);
            });

        }

    };

})($, ClipboardJS);

$(document).ready(function(){
    app.imgur_uploader.init();
});
