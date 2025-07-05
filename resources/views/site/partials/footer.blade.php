<!-- FOOTER START -->
<footer class="site-footer footer-dark">

    <!-- FOOTER BLOCKES START -->
    <div class="footer-top">

        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-12">

                    <div class="widget widget_about">
                        <div class="logo-footer clearfix">
                            <a href="{{route('front.home-page')}}"><img src="{{$config->image ? $config->image->path : ''}}" alt=""></a>
                        </div>
                        <p>{{$config->web_des}}
                        </p>
                        <ul class="social-icons">
                            <li><a href="{{$config->twitter}}"><i
                                        class="bi bi-twitter-x cursor-scale small"></i></a></li>
                            <li><a href="{{$config->facebook}}"><i
                                        class="bi bi-facebook cursor-scale small"></i></a></li>
                            <li><a href="{{$config->instagram}}"><i
                                        class="bi bi-instagram cursor-scale small"></i></a></li>
                            <li><a href="{{$config->linkedin}}"><i
                                        class="bi bi-linkedin cursor-scale small"></i></a></li>
                        </ul>


                    </div>

                </div>



                <div class="col-lg-4 col-md-6">
                    <div class="widget f-top-space">
                        <h3 class="widget-title">Thông Tin</h3>
                        <ul class="widget_address">
                            <li><i class="bi bi-telephone"></i>
                                <span>Số điện thoại</span>
                                {{$config->hotline}}
                            </li>
                            <li><i class="bi bi-geo-alt"></i>
                                <span>Địa chỉ</span>
                                {{$config->address_company}}
                            </li>
                            <li><i class="bi bi-envelope"></i>
                                <span>Email</span>
                                {{$config->email}}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="widget f-top-space recent-posts-entry">
                        <h3 class="widget-title">Vị Trí</h3>
                        {!! $config->location !!}
                    </div>
                </div>



            </div>

        </div>
    </div>
    <!-- FOOTER COPYRIGHT -->

    <div class="footer-bottom">
        <div class="container">
            <div class="container">
                <div class="footer-bottom-info d-flex justify-content-between">
                    <div class="wt-footer-bot-left">
                        <span class="copyrights-text">© 2025 {{$config->web_title}} . Designed By Tuấn Anh Dev</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- FOOTER END -->
