
@extends('layouts.app')

@section('title', 'الاشتراكات الشهرية')

@section('content')

<div class="card mt-4">
  <div class="card-header d-flex justify-content-between align-items-center">
 
    <div>
            <h5 class="mb-0">الاشتراكات الشهرية</h5>
            <p class="text-sm text-muted mb-0">
                متابعة حالة الاشتراكات والتحصيل
            </p>
        </div>

    <!-- زر إضافة قيمة الشهر -->
   <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#generateMonthModal">
    + إنشاء اشتراكات
  </button>
  
  </div>

    <div class="card-header pb-0 d-flex align-items-center justify-content-between">
        

        <div class="d-flex gap-2">

            <button class="btn btn-white btn-icon-only shadow-sm month-prev">
                <i class="fas fa-chevron-right"></i>
            </button>

            <button class="btn btn-white btn-icon-only shadow-sm month-next">
                <i class="fas fa-chevron-left"></i>
            </button>

        </div>

    </div>

    <div class="card-body pt-4">

        <div class="swiper monthSwiper">

            <div class="swiper-wrapper">

                @php
                    $months = $contributions->groupBy('month');
                @endphp

                @foreach($months as $month => $items)

                    @php
                        $amount = $items->first()->expected_amount;

                        $paidCount = $items->where('status','paid')->count();

                        $totalCount = $items->count();

                        $percent = $totalCount
                            ? ($paidCount / $totalCount) * 100
                            : 0;
                    @endphp

                    <div class="swiper-slide">

                            <div class="month-modern-card" style="cursor:pointer" onclick="filterByMonth('{{ $month }}')"
                             data-month="{{ $month }}">


                            <div class="top-section">
                                <div>

                                    <span class="month-label">
                                        {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}
                                    </span>

                                    <h3 class="amount-text">
                                        {{ $amount }}
                                        <small>د.ل</small>
                                    </h3>

                                </div>

                                <div class="month-icon">

                                    <i class="ni ni-calendar-grid-58"></i>

                                </div>

                            </div>

                            <div class="middle-section">

                                <div>

                                    <span class="info-title">
                                        المدفوعين
                                    </span>

                                    <h6>
                                        {{ $paidCount }}/{{ $totalCount }}
                                    </h6>

                                </div>

                                <div>

                                    <span class="info-title">
                                        نسبة التحصيل
                                    </span>

                                    <h6>
                                        {{ intval($percent) }}%
                                    </h6>

                                </div>

                            </div>

                            <div class="progress modern-progress">

                                <div class="progress-bar"
                                     style="width: {{ $percent }}%">
                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>
</div>
            <!-- الجدول يبدء من هني  -->

<div class="card mt-4">
<div class="card-body">

<form id="filterForm" method="GET" action="{{ url('/tables') }}" class="row mb-3">

  <!-- 🔍 البحث -->
  <div class="col-md-3">
    <input type="text" name="search" class="form-control"
           placeholder="بحث باسم العضو"
           value="{{ request('search') }}">
  </div>

  <!-- نوع الفلترة -->
  <div class="col-md-3">
    <select id="filter_type" class="form-control">
      <option value="">اختر نوع الفلترة</option>
      <option value="month">حسب شهر</option>
      <option value="range">من إلى</option>
      <option value="year">سنة كاملة</option>
    </select>
  </div>

  <!-- فلترة حسب شهر -->
  <div class="col-md-2 d-none" id="month_filter">
    <input type="month" name="month" class="form-control">
  </div>

  <!-- من -->
  <div class="col-md-2 d-none" id="from_filter">
    <input type="month" name="from_month" class="form-control">
  </div>

  <!-- إلى -->
  <div class="col-md-2 d-none" id="to_filter">
    <input type="month" name="to_month" class="form-control">
  </div>

  <!-- سنة -->
  <div class="col-md-2 d-none" id="year_filter">
    <input type="number" name="year" class="form-control" placeholder="السنة">
  </div>

  <!-- الأزرار -->
  <div class="col-md-2">
  <button type="button" onclick="submitFilter()" class="btn btn-primary w-100">
    بحث
  </button>
</div>

</form>
</div>
        <div id="contributionsTable" class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>الاسم</th>
                <th>الشهر</th>
                <th>المطلوب</th>
                <th>المدفوع</th>
                <th>الحالة</th>
                <th>الاجراءات</th>
              </tr>
            </thead>

            <tbody>
@foreach($contributions as $contribution)
<tr>
    <td>{{ $contribution->user->name }}</td>

    <td>{{ $contribution->month }}</td>

    <td>{{ $contribution->expected_amount }}</td>

    <td>{{ $contribution->paid_amount }}</td>

    <td>
        @if($contribution->status == 'paid')
            <span class="badge bg-success">تم الدفع</span>
        @elseif($contribution->status == 'partial')
            <span class="badge bg-warning">جزئي</span>
        @else
            <span class="badge bg-danger">غير مدفوع</span>
        @endif
    </td>

    <td>
        @if($contribution->status != 'paid')

          <button class="btn btn-sm btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#payModal{{ $contribution->id }}">
              دفع
          </button>

          @else

          <button class="btn btn-sm btn-success" disabled>
              خالص
          </button>

          @endif
        <!-- <a href="" class="btn btn-sm btn-warning">استثناء</a> -->
    </td>
</tr>

@endforeach
</tbody>
          </table>
        </div>
      </div>
      @foreach($contributions as $contribution)
  <div class="modal fade" id="payModal{{ $contribution->id }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded">

      <div class="modal-header bg-primary text-white">
        <h6 class="mb-0">تسجيل دفعة</h6>
      </div>

      <form method="POST" action="{{ secure_url('/contributions/pay/'.$contribution->id) }}">
        @csrf

        <div class="modal-body">

          <p><b>العضو:</b> {{ $contribution->user->name }}</p>
          <p><b>الشهر:</b> {{ $contribution->month }}</p>

          <label>المبلغ</label>
          <input type="number" name="amount" class="form-control" required>

          <label class="mt-2">نوع الدفع</label>
          <select name="type" class="form-control">
            <option value="single">شهر واحد</option>
            <option value="bulk">مبلغ كبير (توزيع تلقائي)</option>
          </select>

          <label class="mt-2">طريقة الدفع</label>
          <select name="payment_method" class="form-control">
              <option value="bank">تحويل مصرفي</option>
              <option value="cash">كاش</option>
          </select>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
          <button class="btn btn-success">تأكيد</button>
        </div>

      </form>

    </div>
  </div>
</div>

@endforeach
<div class="modal fade" id="generateMonthModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

      <div class="modal-header">
        <h6 class="mb-0">إنشاء اشتراكات شهرية</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ url('/contributions/generate-month') }}">
        @csrf

        <div class="modal-body">

          <!-- شهر البداية -->
          <label>من شهر</label>
          <input type="month" name="from_month" class="form-control mb-3" required>

          <!-- شهر النهاية -->
          <label>إلى شهر (اختياري)</label>
          <input type="month" name="to_month" class="form-control mb-3">

          <!-- القيمة -->
          <label>القيمة الشهرية</label>
          <input type="number" name="amount" class="form-control" value="200" required>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            إلغاء
          </button>

          <button class="btn btn-success">
            إنشاء
          </button>
        </div>

      </form>

    </div>
  </div>

  

    </div>
  </main>
  <!-- مودال التنبيه -->
<div class="modal fade" id="monthExistsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white">
                    الشهر موجود بالفعل
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body text-center py-4">

                <div class="mb-3">
                    <i class="fas fa-exclamation-circle text-warning"
                       style="font-size:60px"></i>
                </div>

                <h5 class="mb-3">
                    هذا الشهر تم إنشاؤه مسبقاً
                </h5>

                <p class="text-muted mb-1">
                    القيمة الحالية:
                </p>

                <h3 id="existingAmount" class="fw-bold text-primary">
                    0 د.ل
                </h3>

                <p class="text-sm text-muted mt-3">
                    عند التأكيد سيتم تعديل القيمة الحالية
                </p>

            </div>

            <div class="modal-footer justify-content-center">

                <button type="button"
                        class="btn btn-light"
                        id="cancelMonthBtn">
                    إلغاء
                </button>

                <button type="button"
                        class="btn btn-warning"
                        id="confirmMonthBtn">
                    نعم، تعديل القيمة
                </button>

            </div>

        </div>
    </div>
</div>
 </div>
 <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <script>
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
          label: "Mobile apps",
          tension: 0.4,
          borderWidth: 0,
          pointRadius: 0,
          borderColor: "#5e72e4",
          backgroundColor: gradientStroke1,
          borderWidth: 3,
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
              color: '#fbfbfb',
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
              color: '#ccc',
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
  
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
document.getElementById('filter_type').addEventListener('change', function () {

  document.getElementById('month_filter').classList.add('d-none');
  document.getElementById('from_filter').classList.add('d-none');
  document.getElementById('to_filter').classList.add('d-none');
  document.getElementById('year_filter').classList.add('d-none');

  if (this.value === 'month') {
    document.getElementById('month_filter').classList.remove('d-none');
  }

  if (this.value === 'range') {
    document.getElementById('from_filter').classList.remove('d-none');
    document.getElementById('to_filter').classList.remove('d-none');
  }

  if (this.value === 'year') {
    document.getElementById('year_filter').classList.remove('d-none');
  }

});
function submitFilter() {

    let form = document.getElementById('filterForm');
    let formData = new FormData(form);

    // إذا كتب اسم → يعتبر بحث
    if (formData.get('search')) {
        formData.append('action', 'search');
    } else {
        formData.append('action', 'filter');
    }

    fetch("{{ url('/contributions') }}?" + new URLSearchParams(formData), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {

        let parser = new DOMParser();
        let doc = parser.parseFromString(html, 'text/html');

        let newTable = doc.getElementById('contributionsTable');

        document.getElementById('contributionsTable').innerHTML = newTable.innerHTML;
      
    });
}

new Swiper(".monthSwiper", {

    slidesPerView: 3,
    spaceBetween: 25,
    loop: false,

    navigation: {
        nextEl: ".month-next",
        prevEl: ".month-prev",
    },

    breakpoints: {

        0: {
            slidesPerView: 1,
        },

        768: {
            slidesPerView: 2,
        },

        1200: {
            slidesPerView: 3,
        }

    }

});
function filterByMonth(month) {

    fetch("{{ url('/contributions') }}?month=" + month, {
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {

        let parser = new DOMParser();
        let doc = parser.parseFromString(html, 'text/html');

        let newTable = doc.getElementById('contributionsTable');

        document.getElementById('contributionsTable').innerHTML =
            newTable.innerHTML;
    });
}
</script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/argon-dashboard.min.js?v=2.1.0"></script>
<script>

let existingMonths = [];

fetch("{{ url('/contributions/existing-months') }}")
.then(res => res.json())
.then(data => {
    existingMonths = data;
});

const generateForm = document.querySelector('#generateMonthModal form');

const fromMonthInput =
    generateForm.querySelector('input[name="from_month"]');

const submitButton =
    generateForm.querySelector('button[type="submit"]');

let allowSubmit = false;

fromMonthInput.addEventListener('change', function () {

    allowSubmit = false;

    let month = this.value;

    let found = existingMonths.find(m => m.month === month);

    if(found){

        document.getElementById('existingAmount').innerText =
            found.expected_amount + ' د.ل';

        let modal = new bootstrap.Modal(
            document.getElementById('monthExistsModal')
        );

        modal.show();

        document.getElementById('confirmMonthBtn').onclick = function () {

            allowSubmit = true;

            modal.hide();
        };

        document.getElementById('cancelMonthBtn').onclick = function () {

            fromMonthInput.value = '';

            modal.hide();
        };
    }
});

generateForm.addEventListener('submit', function(e){

    let month = fromMonthInput.value;

    let found = existingMonths.find(m => m.month === month);

    if(found && !allowSubmit){

        e.preventDefault();

        let modal = new bootstrap.Modal(
            document.getElementById('monthExistsModal')
        );

        modal.show();
    }

});


</script>
  <style>
  body { direction: rtl; }
  .month-modern-card{
    background:#fff;
    border-radius:24px;
    padding:24px;
    border:1px solid #f1f1f1;
    transition:.3s;
    height:100%;
}

.month-modern-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 35px rgba(0,0,0,.08);
}

.top-section{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.month-label{
    font-size:14px;
    color:#8392ab;
    display:block;
    margin-bottom:10px;
}

.amount-text{
    font-size:32px;
    font-weight:700;
    color:#344767;
    margin:0;
}

.amount-text small{
    font-size:15px;
    color:#8392ab;
}

.month-icon{
    width:60px;
    height:60px;
    border-radius:18px;
    background:linear-gradient(135deg,#5e72e4,#825ee4);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:24px;
}

.middle-section{
    display:flex;
    justify-content:space-between;
    margin-bottom:18px;
}

.info-title{
    color:#8392ab;
    font-size:13px;
    display:block;
    margin-bottom:6px;
}

.modern-progress{
    height:10px;
    border-radius:50px;
    background:#edf2f7;
    overflow:hidden;
}

.modern-progress .progress-bar{
    background:linear-gradient(90deg,#2dce89,#2dcecc);
    border-radius:50px;
}

.swiper{
    padding-bottom:10px;
}

</style>

@endsection