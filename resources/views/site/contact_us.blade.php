@extends('site.layouts.master')
@section('title')
    Liên hệ
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection
@section('css')
@endsection

@section('content')
    <!-- CONTENT START -->
    <div class="page-content" ng-controller="ContactUsController">
        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper bg-center">
            <div class="overlay-main innr-bnr-olay"></div>
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">Liên hệ</h2>
                    </div>
                    <!-- BREADCRUMB ROW -->
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                            <li>Liên hệ</li>
                        </ul>
                    </div>
                </div>
                <!-- BREADCRUMB ROW END -->
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->
        <!-- CONTACT FORM -->
        <div class="section-full p-t50 p-b50">
            <div class="section-content">
                <div class="container">
                    <div class="contact-one">
                        <div class="c-info-column-media parallax-section">
                            <img class="parallax-image" src="/site/images/video-h.jpg" alt="#" loading="lazy">
                        </div>
                        <div class="row">
                            <!-- CONTACT INFO -->
                            <div class="col-xl-6 col-lg-6 col-md-12 ">
                                <div class="c-info-column-wrap">
                                    <!-- TITLE START-->
                                    <div class="section-head left wt-small-separator-outer">
                                        <div class="wt-small-separator site-text-primary">
                                            <i class="bi bi-house"></i>
                                            <div>Thông tin liên hệ</div>
                                        </div>
                                        <h2 class="wt-title title_split_anim">Chúng tôi luôn sẵn sàng giúp bạn.</h2>
                                    </div>
                                    <!-- TITLE END-->
                                    <div class="c-info-column">
                                        <div class="c-info-icon"><i class="bi bi-geo-alt"></i></div>
                                        <div class="c-info-detail">
                                            <span class="m-t0">Địa chỉ</span>
                                            <p>{{ $config->address_company }}</p>
                                        </div>
                                    </div>
                                    <div class="c-info-column">
                                        <div class="c-info-icon">
                                            <i class="bi bi-telephone"></i>
                                        </div>
                                        <div class="c-info-detail">
                                            <span class="m-t0">Số điện thoại</span>
                                            <p><a href="tel:{{ str_replace(' ', '', $config->hotline) }}">{{ $config->hotline }}</a></p>
                                        </div>
                                    </div>
                                    <div class="c-info-column">
                                        <div class="c-info-icon"><i class="bi bi-envelope"></i></div>
                                        <div class="c-info-detail">
                                            <span class="m-t0">Email</span>
                                            <p>{{ $config->email }}</p>
                                        </div>
                                    </div>
                                    <div class="c-info-column">
                                        <div class="c-info-icon"><i class="bi bi-door-open"></i></div>
                                        <div class="c-info-detail">
                                            <span class="m-t0">Giờ làm việc</span>
                                            <p>Thứ Hai - Thứ Bảy ( 09.00 AM to 06.00 PM )</p>
                                        </div>
                                    </div>
                                    <div class="social-icons-contact">
                                        <div class="twm-social2">
                                            <ul>
                                                <li><a href="{{ $config->twitter }}" class="tm-s-x"><i
                                                            class="bi bi-twitter-x"></i></a></li>
                                                <li><a href="{{ $config->facebook }}" class="tm-s-fb"><i
                                                            class="bi bi-facebook"></i></a></li>
                                                <li><a href="{{ $config->instagram }}" class="tm-s-in"><i
                                                            class="bi bi-instagram"></i></a></li>
                                                <li><a href="{{ $config->zalo }}" class="tm-s-pi"><i
                                                            class="bi bi-pinterest"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- GET IN TOUCH!-->
                            <div class="col-xl-6 col-lg-6 col-md-12">
                                <div class="contact-info-section">
                                    <div class="contact-form-outer">
                                        <h3 class="wt-title">Gửi thông tin liên hệ</h3>
                                        <p>Hãy để lại thông tin liên hệ cho chúng tôi.</p>
                                        <form class="cons-contact-form" method="post" action="form-handler2.php">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="form-group">
                                                        <input name="username" type="text" required class="form-control" ng-model="your_name"
                                                            placeholder="Họ tên">
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong><% errors.your_name[0] %></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input name="email" type="text" class="form-control" required ng-model="your_email"
                                                            placeholder="Email">
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong><% errors.your_email[0] %></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-12">
                                                    <div class="form-group">
                                                        <input name="phone" type="text" class="form-control" required ng-model="your_phone"
                                                            placeholder="Số điện thoại">
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong><% errors.your_phone[0] %></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" rows="4" placeholder="Nội dung" ng-model="your_message"></textarea>
                                                        <span class="invalid-feedback d-block" role="alert">
                                                            <strong><% errors.your_message[0] %></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="site-button " ng-click="submitContact()">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- GOOGLE MAP -->
        <div class="section-full g-map-wrap">
            <div class="gmap-outline">
                <div class="google-map">
                    <div style="width: 100%">
                        {!! $config->location !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT END -->
@endsection

@push('script')
    <script>
        app.controller('ContactUsController', function($scope, $http) {
            $scope.loading = false;
            $scope.errors = {};
            $scope.submitContact = function() {
                $scope.loading = true;
                let data = {
                    your_name: $scope.your_name,
                    your_email: $scope.your_email,
                    your_phone: $scope.your_phone,
                    your_message: $scope.your_message
                };
                jQuery.ajax({
                    url: '{{ route('front.post-contact') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Thao tác thành công !')
                            $scope.loading = false;
                        } else {
                            $scope.errors = response.errors;
                            toastr.error('Thao tác thất bại !')
                            $scope.loading = false;
                        }
                    },
                    error: function() {
                        toastr.error('Thao tác thất bại !')
                        $scope.loading = false;
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            };
        });
    </script>
@endpush
