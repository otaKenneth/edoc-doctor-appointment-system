<div id="popup1" class="overlay popup-closed">
    <div id="patient-consultation-popup" class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details</p>
                <a class="close popup-closer" href="#">&times;</a>
            </div>
            <div class="popup-content">
                <div class="has-logic" style="display: flex;justify-content: center;">
                    <table width="100%" class="sub-table scrolldown add-doc-form-container" border="0">
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
                        <tr>
                            <form id="patient-diagnosis-form" name="patient-diagnosis-form" method="POST">
                                <td class="label-td" colspan="3">
                                    <label for="name" class="form-label">Diagnosis: </label>
                                </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" colspan="3">
                                <textarea class="input-text" name="diagnosis" rows="5" cols="" placeholder="Aa..."
                                    required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="3">
                                <label for="name" class="form-label">Diagnostic Request: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" colspan="3">
                                <textarea class="input-text" name="diagnostic_request" rows="5" cols=""
                                    placeholder="Aa..." required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="3">
                                <label for="name" class="form-label">Prescription: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" colspan="3">
                                <textarea class="input-text" name="prescription" rows="5" cols="" placeholder="Aa..."
                                    required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="3">
                                <label for="name" class="form-label">Recommendation: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td value-td" colspan="3">
                                <textarea class="input-text" name="recommendation" rows="5" cols="" placeholder="Aa..."
                                    required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding-top: 10px;">
                                <input name="pid" data-value="pid" value="" hidden />
                                <input type="submit" value="Save" form="patient-diagnosis-form"
                                    name="patient-diagnosis-form-submit" class="login-btn btn-primary-soft btn">
                            </td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>

<div id="popup2" class="overlay popup-closed">
    <div id="patient-consultation-history-popup" class="popup">
        <div class="popup-header">
            <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Patient Consultation History</p>
            <a class="close popup-closer" href="#">&times;</a>
        </div>
        <div class="popup-content" style="height: auto; max-height: 400px; overflow-y: scroll;">
            <div class="has-logic border border-rounded border-1 looped hidden" logic-loop>
                <div class="title" style="margin-bottom: 10px;">
                    <span class="form-label">Date:&nbsp;</span>
                    <span data-value="date_created"></span>
                </div>
                <div class="value">
                    <span class="form-label">Diagnosis:&nbsp;</span>
                    <p style="margin-top: 0px;" data-value="diagnosis"></p>
                </div>
                <div class="value">
                    <span class="form-label">Diagnostic Request:&nbsp;</span>
                    <p style="margin-top: 0px;" data-value="diagnostic_request"></p>
                </div>
                <div class="value">
                    <span class="form-label">Prescription:&nbsp;</span>
                    <p style="margin-top: 0px;" data-value="prescription"></p>
                </div>
                <div class="value">
                    <span class="form-label">Recommendation:&nbsp;</span>
                    <p style="margin-top: 0px;" data-value="recommendation"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Save Consultation
        $('form#patient-diagnosis-form').on("submit", function (el) {
            el.preventDefault();
            var form_data = utils.serializeArrayToJSON($(this).serializeArray());

            $.ajax({
                url: "apis/index.php/saveConsultation",
                method: "POST",
                data: form_data,
                contentType: "application/json",
                success: (response) => {
                    if (response.success) {
                        var dialog = $(this).closest('.overlay')
                        utils.closeDialog($(dialog));
                    }
                },
                error: (xhr, textStatus, th) => {
                    // Handle error response
                    console.error('Status code: ' + xhr.status);
                    console.error('Error message: ' + xhr.statusText);
                    console.error('Response: ' + xhr.responseText);
                }
            });
        })

        // Show drop-content
        $('.show-drop-c').click((ev) => {
            var el = $('.drop-content')[0];

            if ($(el).hasClass('drop-content-close')) {
                $(el).removeClass('drop-content-close');
                var child = $(el).children('.main-container')[0];
                $(child).css({
                    'height': 'max-content'
                })
                $(el).addClass('drop-content-open');

                setTimeout(() => {
                    var h = $(el).closest('.popup-content').height();
                    $(el).closest('.popup-content').scrollTop(h + 300);
                }, 300);
            } else {
                $(el).removeClass('drop-content-open');
                var child = $(el).children('.main-container')[0];
                $(child).css({
                    'height': '0px'
                })
                $(el).addClass('drop-content-close');
            }
        })
    })
</script>