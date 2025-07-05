<div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>
        <div class="logo-box">
            <a href="{{route('front.home-page')}}" aria-label="logo image"><img
                    src="{{$config->image ? $config->image->path : 'https://placehold.co/100x100'}}"
                    width="150" alt="" /></a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->
        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:{{$config->email}}">{{$config->email}}</a>
            </li>
            <li>
                <i class="fa fa-phone-alt"></i>
                <a href="tel:{{str_replace(' ', '', $config->hotline)}}">{{$config->hotline}}</a>
            </li>
        </ul>
        <!-- /.mobile-nav__contact -->
        <div class="mobile-nav__top">
            <div class="mobile-nav__social">
                <a href="{{$config->twitter}}"><i class="fab fa-twitter"></i></a>
                <a href="{{$config->facebook}}"><i class="fab fa-facebook-square"></i></a>
                <a href="{{$config->pinterest}}"><i class="fab fa-pinterest-p"></i></a>
                <a href="{{$config->instagram}}"><i class="fab fa-instagram"></i></a>
            </div>
            <!-- /.mobile-nav__social -->
        </div>
        <!-- /.mobile-nav__top -->
    </div>
    <!-- /.mobile-nav__content -->
</div>
<!-- /.mobile-nav__wrapper -->
<div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <!-- /.search-popup__overlay -->
    <div class="search-popup__content">
        <form action="#">
            <label for="search" class="sr-only">search here</label><!-- /.sr-only -->
            <input type="text" id="search" placeholder="Tìm kiếm..." />
            <button type="submit" aria-label="search submit" class="thm-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <!-- /.search-popup__content -->
</div>