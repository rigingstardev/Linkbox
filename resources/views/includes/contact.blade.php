<!--Contact Main-->
<div class="home-contact-main" id="contact">

    <div class="container">
        <h1>About Us</h1>
        <br>
        <div class="row">
            <div class="col-sm-6 cntnt-abt">

                <p>LinkBox helps Doctors remove barriers between their patients and EHR systems by automating the HPI documentation process so they are free to spend maximum time on patient care.</p>

                <button type="button" class="btn btn-default read-more mrgn-tp-20"  onclick="location.href = '{{ url('/about/') }}'">Learn More <i class="fa fa-angle-right" aria-hidden="true"></i></button>


            </div>


            <div class="col-sm-6 address-main">
                <div class="col-sm-12 address">
                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                    <p>13506 Summerport Village Pkwy. #405<br>
                        Windermere, FL 34786</p>
                </div>

                <div class="col-sm-12 address">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    <p>888-508-1968</p>
                </div>

                <!--                <div class="social-media">
                                    <a href="#" class="not-done"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                    <a href="#" class="not-done"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                    <a href="#" class="not-done"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                </div>-->

            </div>
        </div>

        <!-- <div class="col-sm-12">
            <div class="row"><footer>© Copyright 2017 LinkBox. All rights reserved.</footer></div>
        </div> -->
        <div class="col-sm-12">
        <div class="row">
            <footer>
                <div class="col-sm-6">
                    © Copyright {{ now()->year }} LinkBox. All rights reserved.
                </div> 
                <div class="col-sm-6">
                    <a href="/terms-of-use">Terms of Use</a> | 
                    <a href="/privacy-statement">Privacy Statement</a>
                </div>
            </footer>
        </div>
    </div>

    </div>

</div>
<!--Contact Main-->