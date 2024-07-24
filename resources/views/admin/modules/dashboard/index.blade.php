@extends('admin.layouts.app')

@section('content')
<section class="row">
   <div class="col-12 col-lg-9">
       <div class="row">
           <div class="col-6 col-lg-3 col-md-6">
               <div class="card">
                   <div class="card-body px-4 py-4-5">
                       <div class="row">
                           <div
                               class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                               <div class="stats-icon purple mb-2">
                                   <i class="iconly-boldShow"></i>
                               </div>
                           </div>
                           <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                               <h6 class="text-muted font-semibold">Visitors</h6>
                               <h6 class="font-extrabold mb-0">{{number_format($dash_data['visitors'] ?? 0)}}</h6>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-6 col-lg-3 col-md-6">
               <div class="card">
                   <div class="card-body px-4 py-4-5">
                       <div class="row">
                           <div
                               class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                               <div class="stats-icon blue mb-2">
                                   <i class="iconly-boldProfile"></i>
                               </div>
                           </div>
                           <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                               <h6 class="text-muted font-semibold">Blogs</h6>
                               <h6 class="font-extrabold mb-0">{{number_format($dash_data['blogs'] ?? 0)}}</h6>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-6 col-lg-3 col-md-6">
               <div class="card">
                   <div class="card-body px-4 py-4-5">
                       <div class="row">
                           <div
                               class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                               <div class="stats-icon green mb-2">
                                   <i class="iconly-boldAdd-User"></i>
                               </div>
                           </div>
                           <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                               <h6 class="text-muted font-semibold">Events</h6>
                               <h6 class="font-extrabold mb-0">{{number_format($dash_data['events'] ?? 0)}}</h6>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-6 col-lg-3 col-md-6">
               <div class="card">
                   <div class="card-body px-4 py-4-5">
                       <div class="row">
                           <div
                               class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                               <div class="stats-icon red mb-2">
                                   <i class="iconly-boldBookmark"></i>
                               </div>
                           </div>
                           <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                               <h6 class="text-muted font-semibold">Users</h6>
                               <h6 class="font-extrabold mb-0">{{number_format($dash_data['users'] ?? 0)}}</h6>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-12">
               <div class="card">
                   <div class="card-header">
                       <h4>Site Visit</h4>
                   </div>
                   <div class="card-body">
                       <div id="chart-profile-visit"></div>
                   </div>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-12 col-xl-12">
               <div class="card">
                   <div class="card-header">
                       <h4>Volunteers Summary</h4>
                   </div>
                   <div class="card-body">
                       <div class="row">
                           <div class="col-7">
                               <div class="d-flex align-items-center">
                                   <svg class="bi text-primary" width="32" height="32" fill="blue"
                                       style="width:10px">
                                       <use
                                           xlink:href="assets/static/images/bootstrap-icons.svg#circle-fill" />
                                   </svg>
                                   <h5 class="mb-0 ms-3">Volunteers</h5>
                               </div>
                           </div>
                           <div class="col-5">
                               <h5 class="mb-0 text-end">{{number_format($dash_data['users'] ?? 0)}}</h5>
                           </div>
                           <div class="col-12">
                               <div id="chart-europe"></div>
                           </div>
                       </div>
                       
                   </div>
               </div>
           </div>
           
       </div>
   </div>
   <div class="col-12 col-lg-3">
       <div class="card">
           <div class="card-body py-4 px-4">
               <div class="d-flex align-items-center">
                   <div class="avatar avatar-xl">
                       <img src="{{get_image($user->profile_photo?->photo)}}" alt="Face 1">
                   </div>
                   <div class="ms-3 name">
                       <h5 class="font-bold">{{$user->name}}</h5>
                       <h6 class="text-muted mb-0">{{$user->email}}</h6>
                   </div>
               </div>
           </div>
       </div>
       <div class="card">
           <div class="card-header">
               <h4>Recent Messages</h4>
           </div>
           <div class="card-content pb-4">
               <div class="recent-message d-flex px-4 py-3">
                   <div class="avatar avatar-lg">
                       <img src="./assets/compiled/jpg/4.jpg">
                   </div>
                   <div class="name ms-4">
                       <h5 class="mb-1">Hank Schrader</h5>
                       <h6 class="text-muted mb-0">@johnducky</h6>
                   </div>
               </div>
               <div class="recent-message d-flex px-4 py-3">
                   <div class="avatar avatar-lg">
                       <img src="./assets/compiled/jpg/5.jpg">
                   </div>
                   <div class="name ms-4">
                       <h5 class="mb-1">Dean Winchester</h5>
                       <h6 class="text-muted mb-0">@imdean</h6>
                   </div>
               </div>
               <div class="recent-message d-flex px-4 py-3">
                   <div class="avatar avatar-lg">
                       <img src="./assets/compiled/jpg/1.jpg">
                   </div>
                   <div class="name ms-4">
                       <h5 class="mb-1">John Dodol</h5>
                       <h6 class="text-muted mb-0">@dodoljohn</h6>
                   </div>
               </div>
               <div class="px-4">
                   <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>Start
                       Conversation</button>
               </div>
           </div>
       </div>
       <div class="card">
           <div class="card-header">
               <h4>volunteers Gender</h4>
           </div>
           <div class="card-body">
               <div id="chart-visitors-profile"></div>
           </div>
       </div>
   </div>
</section>
@endsection

@push('scripts')
    <!-- Need: Apexcharts -->
    <script src="{{asset('assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
    {{-- <script src="{{asset('assets/static/js/pages/dashboard.js')}}"></script> --}}
    <script>
        var optionsProfileVisit = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            height: 300,
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        series: [
            {
            name: "Visitors",
            data: @json($visitor_data['data']),
            },
        ],
        colors: "#435ebe",
        xaxis: {
            categories: @json($visitor_data['month'])
        },
        }
        let optionsVisitorsProfile = {
            series: @json($dash_data["gender"]),
            labels: ["Male", "Female", "Other"],
            colors: ["#435ebe", "#55c6e8", '#403E41'],
            chart: {
                type: "donut",
                width: "100%",
                height: "350px",
            },
            legend: {
                position: "bottom",
            },
            plotOptions: {
                pie: {
                donut: {
                    size: "30%",
                },
                },
            },
        }

        var optionsEurope = {
        series: [
            {
            name: "Volunteers",
            data: @json($users_data['data']),
            },
        ],
        chart: {
            height: 250,
            type: "area",
            toolbar: {
            show: false,
            },
        },
        colors: ["#5350e9"],
        stroke: {
            width: 2,
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            type: "date",
            categories: @json($users_data['date']),
            axisBorder: {
            show: false,
            },
            axisTicks: {
            show: false,
            },
            labels: {
            show: false,
            },
        },
        show: false,
        yaxis: {
            labels: {
            show: false,
            },
        },
        tooltip: {
            x: {
            format: "dd/MM/yy HH:mm",
            },
        },
        }


        var chartProfileVisit = new ApexCharts(
        document.querySelector("#chart-profile-visit"),
        optionsProfileVisit
        )
        var chartVisitorsProfile = new ApexCharts(
        document.getElementById("chart-visitors-profile"),
        optionsVisitorsProfile
        )
        var chartEurope = new ApexCharts(
        document.querySelector("#chart-europe"),
        optionsEurope
        )


        chartEurope.render()
        chartProfileVisit.render()
        chartVisitorsProfile.render()

    </script>
@endpush