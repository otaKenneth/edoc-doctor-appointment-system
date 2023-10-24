
function showUploads (data) {
    var $imgTemplateEl = $('#files-drag-n-drop #img-template');
    var $pdfTemplateEl = $('#files-drag-n-drop #pdf-template');

    let loc = location;
    let cur_loc = `${loc.protocol}//${loc.hostname}/book-a-consultation/`;

    data.forEach((file, k) => {
        if (file['type'] === "pdf") {
            let $clone = $pdfTemplateEl.clone();
            $clone.removeClass('hidden');
            $clone.addClass('template-copy');
            $clone.removeAttr('id');
            $clone.attr('filekey', file['id']);
            $clone.find('.container-link-fileupload').attr('href', cur_loc+file['location']);
            $clone.find('.filename').text(file['filename']);
            // Display the PDF file as a link
            $("#files-drag-n-drop").append($clone);
        } else if (file['type'] === "image") {
            let $clone = $imgTemplateEl.clone();
            $clone.removeClass('hidden');
            $clone.addClass('template-copy');
            $clone.removeAttr('id');
            $clone.attr('filekey', file['id']);
            $clone.find('.container-link-fileupload').attr('href', cur_loc+file['location']);
            $clone.find('.link-fileuploaded img').attr('src', cur_loc+file['location']);
            $clone.find('.filename').text(file['filename']);
            // Display the image as a preview
            $("#files-drag-n-drop").append($clone);
        }
    })
}

function deleteFile(el) {
    let $el = $(el);
    let $parent = $el.closest(".fileuploaded.template-copy");
    let fileKey = $parent.attr('filekey');

    if ($parent.is("[just-uploaded]")) {
        uploadedFiles.splice(fileKey, 1);
    } else {
        deletedFileKeys.push(fileKey);
    }
    $parent.remove();
}

var deletedFileKeys = [];
var uploadedFiles = [];

$(document).ready(function () {
    // Bind an event handler to the file input change event
    $("#input-file-drag-n-drop").change(function() {
        // Get the selected file
        var $imgTemplateEl = $('#files-drag-n-drop #img-template');
        var $pdfTemplateEl = $('#files-drag-n-drop #pdf-template');

        var newFiles = this.files;
        for (let i = 0; i < newFiles.length; i++) {
            var file = newFiles[i];
            uploadedFiles.push(file);
            
            if (file) {
                // Check if the file is an image
                if (file.type.match('image.*') || file.type === 'application/pdf') {
                    // Create a FileReader to read and display the image
                    var reader = new FileReader();
    
                    reader.onload = (function (file, i) {
                        return function(e) {
                            // e.target.result
                            if (file.type.match('image.*')) {
                                let $clone = $imgTemplateEl.clone();
                                $clone.removeClass('hidden');
                                $clone.addClass('template-copy');
                                $clone.removeAttr('id');
                                $clone.attr('filekey', i);
                                $clone.attr('just-uploaded', true);
                                $clone.find('.container-link-fileupload').attr('href', URL.createObjectURL(file));
                                $clone.find('.link-fileuploaded img').attr('src', e.target.result);
                                $clone.find('.filename').text(file.name);
                                // Display the image as a preview
                                $("#files-drag-n-drop").append($clone);
                            } else if (file.type === 'application/pdf') {
                                let $clone = $pdfTemplateEl.clone();
                                $clone.removeClass('hidden');
                                $clone.addClass('template-copy');
                                $clone.removeAttr('id');
                                $clone.attr('filekey', i);
                                $clone.attr('just-uploaded', true);
                                $clone.find('.container-link-fileupload').attr('href', URL.createObjectURL(file));
                                $clone.find('.filename').text(file.name);
                                // Display the PDF file as a link
                                $("#files-drag-n-drop").append($clone);
                            }
                        }
                    })(file, i);
    
                    // Read the file as a data URL
                    reader.readAsDataURL(file);
                } else {
                    // Display an error message if the selected file is not an image
                    showErrorToast("Selected file is not an image.");
                }
            }
        }

    });
})