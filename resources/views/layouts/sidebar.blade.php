<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-end me-4 rotate-caret" id="sidenav-main">
    
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute start-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
        <img src="../assets/img/logo-ct-dark.png" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo">
        <span class="me-1 font-weight-bold">صندوق التكافل العائلي</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="navbar-collapse px-0 w-auto show" id="sidenav-collapse-main">
    <ul class="navbar-nav">
        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text me-1">لوحة التحكم</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/tables') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text me-1">الاعضاء</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/virtual-reality') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-app text-info text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text me-1">الاشتراكات الشهرية</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/billing') }}">
                <div class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text me-1">المصروفات</span>
            </a>
        </li>

        <li class="nav-item mt-3">
            <h6 class="ps-4 me-4 pe-2 text-uppercase text-xs font-weight-bolder opacity-6">
                صفحات المرافق
            </h6>
        </li>

        

        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf

                <button type="submit"
                        class="nav-link"
                        style="border: none; background: transparent; width: 100%; text-align: right; padding: .5rem 1rem;">

                    <div class="icon icon-shape icon-sm border-radius-md text-center ms-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt text-warning text-sm opacity-10"></i>
                    </div>

                    <span class="nav-link-text ms-1">تسجيل خروج</span>

                </button>
            </form>
        </li>


    </ul>
</div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="../assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
        <div class="card-body text-center p-3 w-100 pt-0">
          <div class="docs-info">
            <h6 class="mb-0 text-center">تحتاج مساعدة?</h6>
            <p class="text-xs font-weight-bold text-center mb-0">يرجى التحقق من مستنداتنا</p>
          </div>
        </div>
      </div>
      <a href="#" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">توثيق</a>
      <a class="btn btn-primary btn-sm mb-0 w-100" href="#" type="button">التطور للاحترافية</a>
    </div>
  </aside>
  