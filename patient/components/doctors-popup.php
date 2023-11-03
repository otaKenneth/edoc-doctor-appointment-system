<div id="dialog-doctor-view" class="overlay popup-closed">
    <div class="popup">
        <center>
            <div class="popup-header">
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
                <a class="close popup-closer" href="#">&times;</a> 
            </div>
            <div class="popup-content" style="display: flex;justify-content: center;">
                <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    <tr>
                        
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Name: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" style="padding-bottom: 15px;" data-value="docname"></td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Email" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" style="padding-bottom: 15px;" data-value="docemail">
                        '.$email.'<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="Tele" class="form-label">Telephone: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" style="padding-bottom: 15px;" data-value="doctel">
                        '.$tele.'<br><br>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="spec" class="form-label">Specialties: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2" style="padding-bottom: 15px;" data-value="sname">
                        '.$spcil_name.'<br><br>
                        </td>
                    </tr>
                </table>
            </div>
        </center>
        <div class="popup-footer">
            <a href="#" class="popup-closer"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
        </div>
    </div>
</div>

<div id="dialog-doctor-sessionlist" class="overlay popup-closed">
    <div class="popup">
        <center>
            <h2>Redirect to Doctors sessions?</h2>
            <a class="close popup-closer" href="#">&times;</a>
            <div class="content">
                You want to view All sessions by <br><span data-value="name"></span>.
            </div>
            <form action="schedule.php" method="post" style="display: flex">
                <input type="hidden" name="search" data-value="name" value="">
                <div style="display: flex;justify-content:center;margin-left:45%;margin-top:6%;">
                    <input type="submit"  value="Yes" class="btn-primary btn">
                </div>
            </form>
        </center>
    </div>
</div>