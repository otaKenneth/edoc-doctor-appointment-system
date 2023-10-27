<table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >   
    <tr>
        <td colspan="4">
            
            <center>
            <table class="filter-container" style="border: none;" border="0">
                <tr>
                    <td colspan="4">
                        <p style="font-size: 20px">&nbsp;</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 25%;">
                        <a href="?action=edit&id=<?php echo $user['pid'] ?>&error=0" class="non-style-link">
                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex">
                            <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                            <div>
                                    <div class="h1-dashboard">
                                        Account Settings  &nbsp;

                                    </div><br>
                                    <div class="h3-dashboard" style="font-size: 15px;">
                                        Edit your Account Details & Change Password
                                    </div>
                            </div>
                                    
                        </div>
                        </a>
                    </td>
                    
                    
                </tr>
                <tr>
                    <td colspan="4">
                        <p style="font-size: 5px">&nbsp;</p>
                    </td>
                </tr>
                <tr>
                <td style="width: 25%;">
                        <a href="?action=view&id=<?php echo $user['pid'] ?>" class="non-style-link">
                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                            <div class="btn-icon-back dashboard-icons-setting " style="background-image: url('../img/icons/view-iceblue.svg');"></div>
                            <div>
                                    <div class="h1-dashboard" >
                                        View Account Details
                                        
                                    </div><br>
                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                        View Personal information About Your Account
                                    </div>
                            </div>
                                    
                        </div>
                        </a>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4">
                        <p style="font-size: 5px">&nbsp;</p>
                    </td>
                </tr>
                <tr>
                <td style="width: 25%;">
                        <a href="?action=drop&id=<?php echo $user['pid'].'&name='.$user['pname'] ?>" class="non-style-link">
                        <div  class="dashboard-items setting-tabs"  style="padding:20px;margin:auto;width:95%;display: flex;">
                            <div class="btn-icon-back dashboard-icons-setting" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                            <div>
                                    <div class="h1-dashboard" style="color: #ff5050;">
                                        Delete Account
                                        
                                    </div><br>
                                    <div class="h3-dashboard"  style="font-size: 15px;">
                                        Will Permanently Remove your Account
                                    </div>
                            </div>
                                    
                        </div>
                        </a>
                    </td>
                    
                </tr>
            </table>
        </center>
        </td>
    </tr>

</table>