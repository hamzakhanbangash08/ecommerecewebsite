<!doctype html>
<html lang="en">
<!--begin::Head-->
@include('layouts.header')
<!--end::Head-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <div class="app-wrapper">

    <!--begin::Header-->
    @include('layouts.navbar')
    <!--end::Header-->

    <!--begin::Sidebar-->
    @include('layouts.sidebar')
    <!--end::Sidebar-->

    <!--begin::App Main-->
    <main class="app-main ">


      <!--begin::App Content Header-->
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            @yield('pageTitle')
          </div>
        </div>
      </div>
      <!--end::App Content Header-->

      <!--begin::App Content-->
      <div class="app-content">


        @yield('content')
        <script>
          const notyf = new Notyf({
            duration: 3000,
            position: {
              x: 'right',
              y: 'top'
            },
            dismissible: true,
          });

          @if(session('success'))
          notyf.success("{{ addslashes(session('success')) }}");
          @endif

          @if(session('error'))
          notyf.error("{{ addslashes(session('error')) }}");
          @endif
        </script>


      </div>
      <!--end::App Content-->

      <!--end::App Content-->

      <!-- @auth
      <h5>Welcome, {{ auth()->user()->name }}!</h5>
      <p>Last Login:
        {{ auth()->user()->last_login_at?->format('d F Y, h:i A') ?? 'No login info' }}
      </p>
      <p>IP Address: {{ auth()->user()->last_login_ip }}</p>

      @endauth -->
    </main>
    <!--end::App Main-->

    <!--begin::Footer-->
    <footer class="app-footer">
      <div class="float-end d-none d-sm-inline">Anything you want</div>
      <strong>
        Copyright &copy; 2014-2024
        <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
      </strong>
      All rights reserved.
    </footer>
    <!--end::Footer-->
  </div>
  <!--end::App Wrapper-->

  <!--begin::Scripts-->
  <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  <!-- OverlayScrollbars Init -->
  <script>
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    const Default = {
      scrollbarTheme: 'os-theme-light',
      scrollbarAutoHide: 'leave',
      scrollbarClickScroll: true,
    };
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
      if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
          scrollbars: {
            theme: Default.scrollbarTheme,
            autoHide: Default.scrollbarAutoHide,
            clickScroll: Default.scrollbarClickScroll,
          },
        });
      }
    });
  </script>

  <!-- SortableJS -->
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
  <script>
    const connectedSortables = document.querySelectorAll('.connectedSortable');
    connectedSortables.forEach((connectedSortable) => {
      new Sortable(connectedSortable, {
        group: 'shared',
        handle: '.card-header',
      });
    });

    document.querySelectorAll('.connectedSortable .card-header').forEach(header => {
      header.style.cursor = 'move';
    });
  </script>



  <!-- ApexCharts -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
    const sales_chart_options = {
      series: [{
          name: 'Digital Goods',
          data: [28, 48, 40, 19, 86, 27, 90],
        },
        {
          name: 'Electronics',
          data: [65, 59, 80, 81, 56, 55, 40],
        },
      ],
      chart: {
        height: 300,
        type: 'area',
        toolbar: {
          show: false
        },
      },
      legend: {
        show: false
      },
      colors: ['#0d6efd', '#20c997'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth'
      },
      xaxis: {
        type: 'datetime',
        categories: [
          '2023-01-01',
          '2023-02-01',
          '2023-03-01',
          '2023-04-01',
          '2023-05-01',
          '2023-06-01',
          '2023-07-01',
        ],
      },
      tooltip: {
        x: {
          format: 'MMMM yyyy'
        },
      },
    };

    const sales_chart = new ApexCharts(document.querySelector('#revenue-chart'), sales_chart_options);
    sales_chart.render();
  </script>

  <!-- jsVectorMap -->
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>
  <script>
    const map = new jsVectorMap({
      selector: '#world-map',
      map: 'world',
    });

    const visitorsData = {
      US: 398,
      SA: 400,
      CA: 1000,
      DE: 500,
      FR: 760,
      CN: 300,
      AU: 700,
      BR: 600,
      IN: 800,
      GB: 320,
      RU: 3000,
    };
  </script>

  <!-- Sparkline charts -->
  <script>
    function renderSparkline(selector, data) {
      new ApexCharts(document.querySelector(selector), {
        series: [{
          data
        }],
        chart: {
          type: 'area',
          height: 50,
          sparkline: {
            enabled: true
          },
        },
        stroke: {
          curve: 'straight'
        },
        fill: {
          opacity: 0.3
        },
        yaxis: {
          min: 0
        },
        colors: ['#DCE6EC'],
      }).render();
    }

    renderSparkline('#sparkline-1', [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021]);
    renderSparkline('#sparkline-2', [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921]);
    renderSparkline('#sparkline-3', [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21]);
  </script>



  <!-- Custom JS -->
  <script src="{{ asset('asset/script/custom.js') }}"></script>

  @yield('scripts')
  <!--end::Scripts-->
</body>

</html>