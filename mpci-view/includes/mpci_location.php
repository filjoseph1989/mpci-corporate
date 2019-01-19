<?php # this will prevent from direct accessing of  this file
if( count(get_included_files()) == 1) die("Error, Contact webtoprint.midtown.com.ph");
?>
<div id="location" class="mpci-margin mpci-background mpci-float-left mpci-width mpci-content">
    <div class="wrapper">
        <div style="padding:10px;">
            <div class="form-title mpci-location">Our Location</div>
			<div class="mpci-contact-map" id="map-canvas"></div>
			<div class="clearfix"></div>
            <div class="mpci-center">You can find us on MPCI Building, Bonifacio Street,Davao City, Philippines 8600</div>
            <div class="mpci-center">Copyright ©<?php echo $this->model->current_year(); ?>| MPCI - Corporate Division.| Midtown Printing Co., Inc</div>
            <div class="mpci-footer">
                <table>
                    <tr><td>PHONE:</td><td>(6382) 211-0821, (6382) 211-3167, (6382) 2213166</td></tr>
                    <tr><td>FAX:</td><td>(6382) 2213201 , (6382) 2213202</td></tr>
                    <tr><td>EMAIL:</td><td>customercare@MPCICorporate.com</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
