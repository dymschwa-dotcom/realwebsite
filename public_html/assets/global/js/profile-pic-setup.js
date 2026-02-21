(function($) {
    "use strict";

    window.setupProfilePicPreview = function(inputSelector, imgSelector, maxSizeMB = 5) {
        $(inputSelector).on('change', function() {
            const file = this.files[0];
            const maxSizeBytes = maxSizeMB * 1024 * 1024;

            if (file) {
                // 1. Check size
                if (file.size > maxSizeBytes) {
                    notify('error', `File is too large. Maximum size allowed is ${maxSizeMB}MB.`);
                    $(this).val(''); // Clear the input
                    return false;
                }

                // 2. Live Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewElement = $(imgSelector);
                    if (previewElement.is('img')) {
                        previewElement.attr('src', e.target.result);
                    } else {
                        previewElement.css('background-image', `url(${e.target.result})`);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
})(jQuery);
