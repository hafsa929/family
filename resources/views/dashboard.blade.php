@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')

<div class="container-fluid py-4">

    {{-- الكروت الرئيسية --}}
    <div class="row">

        <div class="col-xl-3 co l-sm-6 mb-4">
            <div class="card shadow border-0 border-radius-xl">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-secondary mb-1">رصيد الصندوق</p>
                            <h4 class="font-weight-bolder text-dark mb-0">
                                {{ $fundBalance }}
                            </h4>
                        </div>

                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-money-coins text-white text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow border-0 border-radius-xl">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-secondary mb-1">عدد الأعضاء</p>
                            <h4 class="font-weight-bolder text-dark mb-0">
                                {{ $membersCount }}
                            </h4>
                        </div>

                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-single-02 text-white text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow border-0 border-radius-xl">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-secondary mb-1">إجمالي المعاملات</p>
                            <h4 class="font-weight-bolder text-dark mb-0">
                                {{ $totalTransactions }}
                            </h4>
                        </div>

                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-paper-diploma text-white text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow border-0 border-radius-xl">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-secondary mb-1">معاملات اليوم</p>
                            <h4 class="font-weight-bolder text-dark mb-0">
                                {{ $transactionsToday }}
                            </h4>
                        </div>

                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                            <i class="ni ni-cart text-white text-lg opacity-10"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- بطاقة الترحيب --}}
    <div class="row mt-4">

        <div class="col-lg-8 mb-4">
            <div class="card shadow-lg border-0 overflow-hidden">

                <div class="card-body p-0">
                    <div class="row g-0 align-items-center">

                        <div class="col-lg-6 p-4">

                            <div class="p-3">

                                <h6 class="text-primary text-uppercase">
                                    نظام التكافل العائلي
                                </h6>

                                <h2 class="font-weight-bolder mb-3">
                                    لوحة التحكم العائلية
                                </h2>

                                <p class="text-secondary mb-4">
                                    نظام يهدف إلى دعم الأفراد وتعزيز التعاون بين أعضاء العائلة
                                    من خلال المساهمات والخدمات المشتركة.
                                </p>

                                <a href="#" class="btn bg-gradient-primary">
                                    استعراض النظام
                                </a>

                            </div>

                        </div>

                        <div class="col-lg-6 text-center bg-gradient-primary">

                            <img
                                src="../assets/img/illustrations/img88.jpg"
                                class="img-fluid p-4"
                                alt="dashboard-image">

                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- صورة جانبية --}}
        <div class="col-lg-4 mb-4">

            <div class="card shadow-lg border-0 h-100">

                <div class="card-body p-0">

                    <div class="bg-cover h-100 border-radius-xl"
                         style="
                            background-image:url('../assets/img/illustrations/img4.jpg');
                            min-height:320px;
                            background-size:cover;
                            background-position:center;
                         ">


                            

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
{{-- ألبوم الصور --}}
<div class="row mt-4">

    <div class="col-12 mb-4">
        <div class="card shadow border-0">

            <div class="card-header bg-transparent border-0">
                <h5 class="font-weight-bolder mb-0">
                    ألبوم الصور
                </h5>
                <p class="text-sm text-secondary mb-0">
                    صور تعكس نشاط النظام والمستخدمين
                </p>
            </div>

            <div class="card-body">

                <div class="row g-3">

                  <div class="col-lg-3 col-md-4 col-6">
                    <img id="img1" src="../assets/img/illustrations/img11.jpg"
                            class="img-fluid rounded shadow-sm hover-zoom"
                            style="height:220px;width:100%;object-fit:cover">
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <img id="img2" src="../assets/img/illustrations/img5.jpeg"
                            class="img-fluid rounded shadow-sm hover-zoom"
                            style="height:220px;width:100%;object-fit:cover">
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <img id="img3" src="../assets/img/illustrations/img10.jpg"
                            class="img-fluid rounded shadow-sm hover-zoom"
                            style="height:220px;width:100%;object-fit:cover">
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <img id="img4" src="../assets/img/illustrations/img9.jpg"
                            class="img-fluid rounded shadow-sm hover-zoom"
                            style="height:220px;width:100%;object-fit:cover">
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>

{{-- ستايل بسيط للحركة --}}
<style>
.hover-zoom{
    transition: 0.3s;
    cursor: pointer;
}
.hover-zoom:hover{
    transform: scale(1.05);
}
</style>


{{-- Scripts --}}
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../assets/js/plugins/chartjs.min.js"></script>
<script>
const photos = [
    "../assets/img/illustrations/img10.jpg",
    "../assets/img/illustrations/img12.png",
    "../assets/img/illustrations/img122.png",
    "../assets/img/illustrations/img4.jpg",
    "../assets/img/illustrations/img5.jpeg",
    "../assets/img/illustrations/img8.jpg",
    "../assets/img/illustrations/img7.jpeg",
    "../assets/img/illustrations/img88.jpg",
    "../assets/img/illustrations/img9.jpg",
    "../assets/img/illustrations/img11.jpg",
    // "../assets/img/illustrations/img11.jpg",
    "../assets/img/illustrations/img12.png"
];

let current = 0;

function changeImages() {

    document.getElementById("img1").src = photos[current % photos.length];
    document.getElementById("img2").src = photos[(current + 1) % photos.length];
    document.getElementById("img3").src = photos[(current + 2) % photos.length];
    document.getElementById("img4").src = photos[(current + 3) % photos.length];

    current += 4;
}

setInterval(changeImages, 5000);
// نهايه الصور وتنسيقها 

    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');

    new Chart(ctx1, {
        type: "line",

        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

            datasets: [{
                label: "المعاملات",
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                fill: true,

                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6
            }],
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: false,
                }
            },

            interaction: {
                intersect: false,
                mode: 'index',
            },

            scales: {

                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },

                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#9ca2b7',

                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },

                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },

                    ticks: {
                        display: true,
                        color: '#9ca2b7',
                        padding: 20,

                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },

            },
        },
    });
</script>

<script>
    var win = navigator.platform.indexOf('Win') > -1;

    if (win && document.querySelector('#sidenav-scrollbar')) {

        var options = {
            damping: '0.5'
        }

        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>



@endsection