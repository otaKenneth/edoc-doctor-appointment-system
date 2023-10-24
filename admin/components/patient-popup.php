<div id="popup1" class="overlay popup-closed">
    <div class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details</p>
                <a class="close popup-closer" href="#">&times;</a>
            </div>
            <div class="popup-content">
                <div class="has-logic" style="display: flex;justify-content: center;">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td class="label-td">
                                <label for="name" class="form-label"><b>Patient ID: </b></label>
                            </td>
                            <td class="label-td value-td" colspan="2" data-value="pid"></td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="name" class="form-label"><b>Name: </b></label>
                            </td>
                            <td class="label-td value-td" colspan="2" data-value="pname"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><br></td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="Email" class="form-label">Email: </label>
                            </td>
                            <td class="label-td">
                                <label for="Tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" data-value="pemail"></td>
                            <td class="label-td value-td" colspan="2" data-value="ptel"></td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="spec" class="form-label">Address: </label>
                            </td>
                            <td class="label-td">
                                <label for="name" class="form-label">Date of Birth: </label>
                            </td>
                            <td class="label-td">
                                <label for="name" class="form-label">Age: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" data-value="paddress"></td>
                            <td class="label-td value-td" data-value="pdob"></td>
                            <td class="label-td value-td" data-value="age"></td>
                        </tr>
                    </table>
                </div>
                <div class="container-drag-n-drop">
                    <div class="content-drag-n-drop">
                        <div id="files-drag-n-drop">
                            <button type="button" class="clickable-drag-n-drop">
                                <label for="input-file-drag-n-drop">
                                    <img src="../img/icons/fileupload.svg" alt="Drag n Drop"
                                        style="height: 40px;"
                                    >
                                    PDF/IMG
                                </label>
                            </button>
                            <!-- image -->
                            <div id="img-template" class="fileuploaded img hidden">
                                <div class="delete-button" onclick="deleteFile(this)">
                                    <img src="../img/icons/delete-white.svg" alt="Delete">
                                </div>
                                <a href="" target="_blank" class="container-link-fileupload" style="height: 100%; width: 100%;">
                                    <div class="link-fileuploaded">
                                        <img style="width: 100%; height: 100%;" src="" alt="Preview">
                                        <span class="filename"></span>
                                    </div>
                                </a>
                            </div>
                            <!-- file -->
                            <div id="pdf-template" class="fileuploaded pdf hidden">
                                <div class="delete-button" onclick="deleteFile(this)">
                                    <img src="../img/icons/delete-white.svg" alt="Delete">
                                </div>
                                <a href="" target="_blank" class="container-link-fileupload" style="height: 100%; width: 100%;">
                                    <div class="link-fileuploaded">
                                        <img src="../img/icons/pdf-red.svg" alt="" 
                                            style="height: 40px;"
                                        >
                                        <span class="filename"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <input id="input-file-drag-n-drop" type="file" class="input-drag-n-drop hidden" accept="image/*, application/pdf" multiple>
                    </div>
                </div>
            </div>
        </center>
        <div class="popup-footer">
            <a href="#"><input id="ok" type="button" value="OK" class="login-btn btn-primary-soft btn submit" ></a>
            <a href="#" class="popup-closer"><input id="close" type="button" value="Close" class="login-btn btn-secondary-soft btn"></a>
        </div>
    </div>
</div>
<script>
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

    $('#ok.submit').click((e) => {
        if (uploadedFiles.length === 0 && deletedFileKeys.length === 0) {
            showErrorToast("Please upload files first.")
            return;
        }

        // Create a FormData object to send the files to the server
        var formData = new FormData();
        for (var i = 0; i < uploadedFiles.length; i++) {
            formData.append('file[]', uploadedFiles[i]);
        }

        if (deletedFileKeys.length > 0) {
            formData.append('deleted', JSON.stringify(deletedFileKeys))
        }
        var id = $(e.currentTarget).closest('.overlay').attr('data-id');
        formData.append('patient_id', id);

        $.ajax({
            url: 'apis/index.php/uploadPatientFiles', // Replace with the path to your PHP backend script
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle the server's response, if needed
                if (response.success) {
                    showSuccessToast(response.message)
                    deletedFileKeys = [];
                    uploadedFiles = [];
                }
            },
            error: function(xhr, status, error) {
                // Handle errors, if any
                console.log("Error: " + error);
                let response = JSON.parse(xhr.responseText);
                showErrorToast([response.message]);
            }
        });
    })
})

function deleteFile(el) {
    let $el = $(el);
    let $parent = $el.closest(".fileuploaded.template-copy");
    let fileKey = $parent.attr('filekey');

    console.log(fileKey, $parent);
    if ($parent.is("[just-uploaded]")) {
        uploadedFiles.splice(fileKey, 1);
    } else {
        deletedFileKeys.push(fileKey);
    }
    $parent.remove();
}
</script>