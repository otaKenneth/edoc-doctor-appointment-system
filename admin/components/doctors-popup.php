<div id="popup1" class="overlay popup-closed">
    <div class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Doctor.</p><br><br>
                <a class="close popup-closer" href="#">&times;</a> 
            </div>
            <div style="display: flex;justify-content: center;">
                <div class="popup-content">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <form id="add-new-doctor" method="POST" class="add-new-form">
                            <td class="label-td" colspan="2">
                                <label for="name" class="form-label">Name: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="text" name="name" class="input-text" placeholder="Doctor Name" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2" data-value="error_message"></td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="Email" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="email" name="email" class="input-text" placeholder="Email Address" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="tele" class="form-label">Telephone: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="tel" name="tele" class="input-text" placeholder="Telephone Number" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="spec" class="form-label">Choose specialties: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <select name="spec" id="" class="box">
                                    <?php
                                    foreach ($admin_cache_data['specialties'] as $row00) {
                                        $sn = $row00["sname"];
                                        $id00 = $row00["id"]; ?>
                                        <option value="<?=$id00?>"><?=$sn?></option>
                                    <?php } ?>
                                </select><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="password" class="form-label">Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="password" class="input-text" placeholder="Defind a Password" required><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <label for="cpassword" class="form-label">Conform Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required><br>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
        <div class="popup-footer">
            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" form="add-new-doctor" value="Add" class="login-btn btn-primary btn">
        </div>
    </div>
</div>

<div id="popup2" class="overlay popup-closed">
    <div class="popup">
        <center>
            <h2></h2>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                <a class="close popup-closer" href="#">&times;</a>
            </div>
            <div class="has-logic" style="display: flex;justify-content: center;">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                        <td class="label-td" colspan="2">
                            <form id="doctors-view" method="POST">
                            <label for="name" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td editable" width="5%"></td>
                        <td class="label-td" colspan="2" data-value="docname"></td>
                        <td class="label-td hidden" colspan="2">
                            <input class="field-editable input-text" type="text" name="docname" data-value="docname" value="">
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td editable" width="5%"></td>
                        <td class="label-td" colspan="2" data-value="docemail"></td>
                        <td class="label-td hidden" colspan="2">
                            <input type="text" name="docemail" data-value="docemail" value="" class="field-editable input-text">
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td editable" width="5%"></td>
                        <td class="label-td" colspan="2" data-value="doctel"></td>
                        <td class="label-td hidden" colspan="2">
                            <input type="text" class="field-editable input-text" data-value="doctel" value="" name="doctel">
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Specialties: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td editable" width="5%"></td>
                        <td class="label-td" colspan="2" data-value="sname"></td>
                        <td class="label-td hidden" colspan="2">
                            <select name="specialties" class="field-editable box" data-value="specialties">
                            <?php
                            foreach ($admin_cache_data['specialties'] as $row00) {
                                $sn = $row00["sname"];
                                $id00 = $row00["id"]; ?>
                                <option value="<?=$id00?>"><?=$sn?></option>
                            <?php } ?>
                            </select>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
        <div class="popup-footer">
            <a href="#"><input type="submit" form="doctors-view" value="OK" class="login-btn btn-primary-soft btn" ></a>
        </div>
    </div>
</div>

<div id="popup3" class="overlay popup-closed">
    <div class="popup">
        <center>
            <h2>Are you sure?</h2>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content">
                You want to delete this record<br>(<span data-value="name"></span>).
            </div>
            <div style="display: flex;justify-content: center;">
                <a href="#" class="non-style-link" onclick="dropYes(this)">
                    <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                        <font class="tn-in-text">&nbsp;Yes&nbsp;</font>
                    </button>
                </a>&nbsp;&nbsp;&nbsp;
                <a href="#" class="non-style-link popup-closer">
                    <button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;">
                        <font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font>
                    </button>
                </a>
            </div>
        </center>
    </div>
</div>

<script>
    $(document).ready(() => {
        $('form#add-new-doctor').on("submit", function (el) {
            el.preventDefault();
            var form_data = utils.serializeArrayToJSON($(this).serializeArray());

            $.ajax({
                url: "apis/index.php/addDoctor",
                method: "POST",
                data: form_data,
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var dialog = $(this).closest('.overlay')
                        $(dialog).removeClass('popup-open');
                        $(dialog).addClass('popup-closed');
                        showSuccessToast(response.message)
                        utils.pageReload(4500)
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Error message: ' + xhr.statusText);
                    let response = JSON.parse(xhr.responseText);
                    console.log(typeof(response.message))
                    showErrorToast(response.message)
                }
            })

        })

        $('form#doctors-view').on('submit', function (el) {
            el.preventDefault();
            form.id = "doctors-view";

            $.ajax({
                url: "apis/index.php/updateDoctor",
                method: "POST",
                data: JSON.stringify({
                    changes: form.changes,
                    original: objDoctorsData.docid,
                }),
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        showSuccessToast([response.message])
                        utils.pageReload(4500)
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Error message: ' + xhr.statusText);
                    let response = JSON.parse(xhr.responseText);
                    showErrorToast([response.message]);
                }
            })
        })
    })

    function dropYes(el) {
        var parent = $(el).closest('.overlay')[0];
        var data_id = $(parent).attr('data-id')
        var dialogId = $(parent).attr('id');

        $.ajax({
            url: "apis/index.php/deleteDoctor",
            method: "POST",
            data: JSON.stringify({
                id: data_id
            }),
            contentType: "application/json",
            success: (response) => {
                if (response.success) {
                    utils.closeDialog($(`#${dialogId}`))
                    showSuccessToast(response.message)
                    utils.pageReload(4500)
                }
            },
            error: (xhr, textStatus, th) => {
                // Handle error response
                console.error('Error message: ' + xhr.statusText);
                let response = JSON.parse(xhr.responseText);
                showErrorToast(response.message);
            }
        })
    }
</script>