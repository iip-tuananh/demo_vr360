@extends('site.layouts.master')
@section('title')
@endsection
@section('description')
@endsection
@section('image')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #pano {
            width: 100%;
            height: 100%;
            background: #000;
            overflow: hidden;
            /* position: relative; */
        }

        .hotspot {
            width: 100px;
            height: 100px;
            background: url('/site/images/up.png') no-repeat center center;
            background-size: contain;
            cursor: pointer;
        }

        .timeline.collapsed {
            transform: translateY(100%);
            /* Ẩn xuống dưới */
        }

        .timeline-toggle.active {
            bottom: 0;
            transform: translateY(0);
        }

        .timeline-toggle {
            position: absolute;
            bottom: 100px;
            /* ngay phía trên timeline */
            left: 0;
            z-index: 1100;
            background: #fff;
            color: #000;
            border-radius: 0;
            border-top-right-radius: 5px;
            width: 50px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            cursor: pointer;
            user-select: none;
            transition: transform 0.3s ease, bottom 0.3s ease;
        }

        .timeline {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: rgba(0, 0, 0, 0.7);
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            z-index: 1000;
            transition: height 0.3s ease, transform 0.3s ease;
        }

        .timeline-item {
            display: inline-block;
            margin: 0 10px;
            cursor: pointer;
            text-align: center;
            color: white;
        }

        .timeline-item img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border: 2px solid white;
            border-radius: 4px;
        }

        .timeline-item span {
            display: block;
            margin-top: 5px;
            font-size: 12px;
        }

        .back-button {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1000;
            background: #ffffff;
            padding: 6px 10px;
            font-size: 22px;
            cursor: pointer;
        }

        .auto-rotate-button {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 1000;
            background: #ffffff;
            padding: 10px 20px;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div id="pano" ng-controller="Vr360Controller" ng-init="init()">
        <div class="back-button" ng-click="back()">
            <i class="fa fa-arrow-left"></i>
        </div>
        <div class="auto-rotate-button" ng-click="autoRotateInterval ? stopAutoRotate() : startAutoRotate()">
            <i class="fa-solid fa-play" ng-show="!autoRotateInterval"></i>
            <i class="fa-solid fa-pause" ng-show="autoRotateInterval"></i>
        </div>
        <!-- Nút toggle collapse -->
        <div class="timeline-toggle" ng-click="toggleTimeline()" ng-class="{ 'active': timelineCollapsed }">
            <span ng-if="!timelineCollapsed">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
            <span ng-if="timelineCollapsed">
                <i class="fa-solid fa-chevron-up"></i>
            </span>
        </div>
        <!-- Thanh timeline -->
        <div class="timeline" ng-class="{ 'collapsed': timelineCollapsed }">
            <div class="timeline-item" ng-repeat="scene in scenes" ng-click="jumpToScene(scene.key)">
                <img ng-src="<% scene.thumb %>" loading="lazy" />
                <span><% scene.name %></span>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="/site/js/marzipano-0.10.2/marzipano.js"></script>
    <script>
        app.controller('Vr360Controller', function($scope, $http, $timeout) {
            $scope.autoRotateInterval = null;
            $scope.autoRotateSpeed = 0.001;
            $scope.timelineCollapsed = false;
            const viewer = new Marzipano.Viewer(document.getElementById('pano'));

            // Define scenes
            $scope.scenes = [{
                    key: 'room1',
                    name: 'Image 1',
                    thumb: @json(asset('site/images/thumb/1.png')),
                    image: @json(asset('site/images/1.jpg')),
                    hotspots: [{
                        yaw: -0.044661044233359704,
                        pitch: 0.1590913321552474,
                        reverseYaw: -0.004655253972154938,
                        reversePitch: 0.13738950898830282,
                        target: 'room2'
                    }]
                },
                {
                    key: 'room2',
                    name: 'Image 2',
                    thumb: @json(asset('site/images/thumb/2.png')),
                    image: @json(asset('site/images/2.jpg')),
                    hotspots: [{
                        yaw: -0.14788168128712265,
                        pitch: 0.11233475477682475,
                        reverseYaw: -0.12029922054690978,
                        reversePitch: 0.1089946963874393,
                        target: 'room3'
                    }, {
                        yaw: -3.0909025857429455,
                        pitch: 0.2166583254171197,
                        reverseYaw: -3.1022417746312225,
                        reversePitch: 0.16664712158788397,
                        target: 'room1'
                    }]
                },
                {
                    key: 'room3',
                    name: 'Image 3',
                    thumb: @json(asset('site/images/thumb/3.png')),
                    image: @json(asset('site/images/3.jpg')),
                    hotspots: [{
                        yaw: -0.13236278417052283,
                        pitch: 0.17448391856134293,
                        reverseYaw: -0.1710716800694172,
                        reversePitch: 0.17724485894850517,
                        target: 'room4'
                    }, {
                        yaw: 2.8453424607151305,
                        pitch: 0.1911328561006087,
                        reverseYaw: -3.1017930335655937,
                        reversePitch: 0.36222905747897016,
                        target: 'room2'
                    }]
                },
                {
                    key: 'room4',
                    name: 'Image 4',
                    thumb: @json(asset('site/images/thumb/4.png')),
                    image: @json(asset('site/images/4.jpg')),
                    hotspots: [{
                        yaw: -0.3835670050583566,
                        pitch: 0.4174823377873338,
                        reverseYaw: 0.048103956416643,
                        reversePitch: 0.21248422434896064,
                        target: 'room5'
                    }, {
                        yaw: -2.9583084159876147,
                        pitch: 0.19618345189304343,
                        reverseYaw: 2.8848236587480045,
                        reversePitch: 0.09413906711443154,
                        target: 'room3'
                    }]
                },
                {
                    key: 'room5',
                    name: 'Image 5',
                    thumb: @json(asset('site/images/thumb/5.png')),
                    image: @json(asset('site/images/5.jpg')),
                    hotspots: [{
                        yaw: 0.048103956416643,
                        pitch: 0.21248422434896064,
                        reverseYaw: 0.13259406567399523,
                        reversePitch: 0.1425875088558648,
                        target: 'room6'
                    }, {
                        yaw: -2.2504852185029307,
                        pitch: 0.4532822652913886,
                        reverseYaw: -2.9578264300840758,
                        reversePitch: 0.1264161898104348,
                        target: 'room4'
                    }]
                },
                {
                    key: 'room6',
                    name: 'Image 6',
                    thumb: @json(asset('site/images/thumb/6.png')),
                    image: @json(asset('site/images/6.jpg')),
                    hotspots: [{
                        yaw: 0.13259406567399523,
                        pitch: 0.1425875088558648,
                        reverseYaw: 1.8271317739138162,
                        reversePitch: 0.08521707029892411,
                        target: 'room7'
                    }, {
                        yaw: -3.0856058440188434,
                        pitch: 0.26168952549497604,
                        reverseYaw: -1.8916591098553077,
                        reversePitch: 0.1989942615766207,
                        target: 'room5'
                    }]
                },
                {
                    key: 'room7',
                    name: 'Image 7',
                    thumb: @json(asset('site/images/thumb/7.png')),
                    image: @json(asset('site/images/7.jpg')),
                    hotspots: [{
                        yaw: 1.8086255092924235,
                        pitch: 0.3162530429461654,
                        reverseYaw: 1.1184565781321893,
                        reversePitch: 0.12486484896059658,
                        target: 'room8'
                    }, {
                        yaw: -3.0735431646427163,
                        pitch: 0.2667894233431092,
                        reverseYaw: -3.0735431646427163,
                        reversePitch: 0.2667894233431092,
                        target: 'room6'
                    }]
                },
                {
                    key: 'room8',
                    name: 'Image 8',
                    thumb: @json(asset('site/images/thumb/8.png')),
                    image: @json(asset('site/images/8.jpg')),
                    hotspots: [{
                        yaw: 1.055731486885378,
                        pitch: 0.31436539667032015,
                        reverseYaw: -0.05132175379004522,
                        reversePitch: 0.10036273490876013,
                        target: 'room9'
                    }, {
                        yaw: -3.035703954822008,
                        pitch: 0.3341116274171423,
                        reverseYaw: -3.0468363441483284,
                        reversePitch: 0.10689148963929895,
                        target: 'room7'
                    }]
                },
                {
                    key: 'room9',
                    name: 'Image 9',
                    thumb: @json(asset('site/images/thumb/9.png')),
                    image: @json(asset('site/images/9.jpg')),
                    hotspots: [{
                        yaw: -0.06662524638679557,
                        pitch: 0.2560991632523546,
                        reverseYaw: 0.05252640388199481,
                        reversePitch: 0.08680763875908681,
                        target: 'room10'
                    }, {
                        yaw: 2.5690705027333562,
                        pitch: 0.36265384187439587,
                        reverseYaw: -2.9419073258340127,
                        reversePitch: 0.1554298217334793,
                        target: 'room8'
                    }]
                },
                {
                    key: 'room10',
                    name: 'Image 10',
                    thumb: @json(asset('site/images/thumb/10.png')),
                    image: @json(asset('site/images/10.jpg')),
                    hotspots: [{
                        yaw: -2.750853005770363,
                        pitch: 0.19130024834103665,
                        reverseYaw: 1.569864255271331,
                        reversePitch: 0.15588908379945643,
                        target: 'room11'
                    }, {
                        yaw: 2.859489653979808,
                        pitch: 0.27612067736581025,
                        reverseYaw: 2.859489653979808,
                        reversePitch: 0.27612067736581025,
                        target: 'room9'
                    }]
                },
                {
                    key: 'room11',
                    name: 'Image 11',
                    thumb: @json(asset('site/images/thumb/11.png')),
                    image: @json(asset('site/images/11.jpg')),
                    hotspots: [{
                        yaw: 1.536894591978907,
                        pitch: 0.1952665505679434,
                        reverseYaw: -0.04642573703354813,
                        reversePitch: 0.011123554221867948,
                        target: 'room12'
                    }, {
                        yaw: -1.1900020583224364,
                        pitch: 0.18471395649535616,
                        reverseYaw: 0.02870605110113189,
                        reversePitch: 0.11225093154784815,
                        target: 'room10'
                    }]
                },
                {
                    key: 'room12',
                    name: 'Image 12',
                    thumb: @json(asset('site/images/thumb/12.png')),
                    image: @json(asset('site/images/12.jpg')),
                    hotspots: [{
                        yaw: -1.5713710100878266,
                        pitch: 0.20566869026094992,
                        reverseYaw: -1.1330173805882495,
                        reversePitch: 0.1166533079835741,
                        target: 'room11'
                    }]
                }
            ];

            const sceneData = {};

            let currentSceneName = 'room1';

            // Create scenes
            angular.forEach($scope.scenes, function(data) {
                const source = Marzipano.ImageUrlSource.fromString(data.image);
                const geometry = new Marzipano.EquirectGeometry([{
                    width: 4000
                }]);
                const viewLimiter = Marzipano.RectilinearView.limit.traditional(1024, 100 * Math
                    .PI / 180);
                const view = new Marzipano.RectilinearView(null, viewLimiter);

                const scene = viewer.createScene({
                    source,
                    geometry,
                    view
                });

                // Tạo hotspot
                data.hotspots.forEach(function(h) {
                    const el = document.createElement('div');
                    el.className = 'hotspot';

                    // Tính toán góc xoay từ yaw (radian -> degree)
                    const deg = h.yaw * (180 / Math.PI);
                    el.style.transform = `rotateZ(${deg}deg)`;

                    el.addEventListener('click', function() {
                        // switchScene(h.target);
                        animateAndSwitchScene(h.target, h.yaw, h.pitch, {
                            yaw: h.reverseYaw,
                            pitch: h.reversePitch
                        });
                    });

                    scene.hotspotContainer().createHotspot(el, {
                        yaw: h.yaw,
                        pitch: h.pitch
                    });
                });

                // sceneData[key] = scene;
                sceneData[data.key] = {
                    scene: scene,
                    view: view
                };
            });

            function animateAndSwitchScene(targetScene, yawToLookAt, pitchToLookAt, reverseView = null) {
                const currentView = sceneData[currentSceneName].view;

                // 1. Quay camera về hướng của hotspot
                currentView.setYaw(yawToLookAt, {
                    transitionDuration: 500
                });
                currentView.setPitch(pitchToLookAt, {
                    transitionDuration: 500
                });

                // 2. Gán reverseView để dùng khi quay lại
                sceneData[targetScene].entryView = reverseView;

                setTimeout(() => {
                    sceneData[targetScene].scene.switchTo({
                        transitionDuration: 1000
                    });
                    currentSceneName = targetScene;

                    // Nếu có reverseView, thì đặt lại góc nhìn
                    if (reverseView) {
                        const view = sceneData[targetScene].view;
                        view.setYaw(reverseView.yaw);
                        view.setPitch(reverseView.pitch);
                    }
                }, 0);
            }

            $scope.jumpToScene = function(sceneKey) {
                if (!sceneData[sceneKey]) return;

                // Nếu muốn giữ hướng cũ thì dùng `switchTo`, hoặc set góc mới nếu cần
                sceneData[sceneKey].scene.switchTo({
                    transitionDuration: 1000
                });
                currentSceneName = sceneKey;
            };

            // function switchScene(name) {
            //     sceneData[name].switchTo({
            //         transitionDuration: 1000
            //     });
            //     currentSceneName = name;
            // }

            // // Load scene đầu tiên
            // switchScene('room1');
            animateAndSwitchScene('room1', 0, 0);

            // hàm lấy góc nhìn của camera
            // $timeout(function() {
            //     document.getElementById('pano').addEventListener('click', function(e) {
            //         console.log('click');
            //         const coords = viewer.view().screenToCoordinates({
            //             x: e.clientX,
            //             y: e.clientY
            //         });
            //         console.log('Yaw:', coords.yaw, 'Pitch:', coords.pitch);
            //     });
            // }, 0);

            // Auto rotate
            $scope.startAutoRotate = function() {
                if (!currentSceneName) return;
                const view = sceneData[currentSceneName].view;

                // Dừng trước nếu đang chạy
                $scope.stopAutoRotate();

                $scope.autoRotateInterval = setInterval(function() {
                    const yaw = view.yaw();
                    view.setYaw(yaw + $scope.autoRotateSpeed); // tốc độ xoay nhỏ để mượt
                }, 16); // khoảng 60fps
            };

            // Stop auto rotate
            $scope.stopAutoRotate = function() {
                if ($scope.autoRotateInterval) {
                    clearInterval($scope.autoRotateInterval);
                    $scope.autoRotateInterval = null;
                }
            };

            // Toggle timeline
            $scope.toggleTimeline = function() {
                $scope.timelineCollapsed = !$scope.timelineCollapsed;
            };

            $scope.back = function() {
                window.location.href = '{{ route('front.home-page') }}';
            };
        })
    </script>
@endpush
