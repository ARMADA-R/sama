   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
       <div class="navbar-header">
           <ul class="nav navbar-nav flex-row">
               <li class="nav-item me-auto"><a class="navbar-brand" href="{{ url('design') }}/html/rtl/vertical-menu-template/index.html"><span class="brand-logo">
                           <svg viewbox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                               <defs>
                                   <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                                       <stop stop-color="#000000" offset="0%"></stop>
                                       <stop stop-color="#FFFFFF" offset="100%"></stop>
                                   </lineargradient>
                                   <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                                       <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                       <stop stop-color="#FFFFFF" offset="100%"></stop>
                                   </lineargradient>
                               </defs>
                               <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                   <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                                       <g id="Group" transform="translate(400.000000, 178.000000)">
                                           <path class="text-primary" id="Path" d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z" style="fill:currentColor"></path>
                                           <path id="Path1" d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z" fill="url(#linearGradient-1)" opacity="0.2"></path>
                                           <polygon id="Path-2" fill="#000000" opacity="0.049999997" points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                                           <polygon id="Path-21" fill="#000000" opacity="0.099999994" points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                                           <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994" points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                                       </g>
                                   </g>
                               </g>
                           </svg></span>
                       <h2 class="brand-text">Sama</h2>
                   </a></li>
               <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
           </ul>
       </div>
       <div class="shadow-bottom"></div>
       <div class="main-menu-content">
           <ul class="navigation navigation-main " id="main-menu-navigation" data-menu="menu-navigation">
               @can('viewAny', App\Models\User::class)
               <li class=" nav-item font-tajawal">
                   <a class="d-flex align-items-center" href="index.html">
                       <i data-feather='users'></i>
                       <span class="menu-title text-truncate" data-i18n="Dashboards">
                           {{ trans("general.Users and Accounts") }}
                       </span>
                       <!-- <span class="badge badge-light-warning rounded-pill ms-auto me-1">
                           2
                       </span> -->
                   </a>
                   <ul class="menu-content">

                       <li class="{{ (Request::is('admin/users')  || Request::is('admin/users/*')? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.users')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="Analytics">
                                   {{ trans("general.Admins") }}
                               </span>
                           </a>
                       </li>

                       <li class="{{ (Request::is('admin/headmasters')  || Request::is('admin/headmasters/*')? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.headmasters')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="Analytics">
                                   {{ trans("general.headmasters") }}
                               </span>
                           </a>
                       </li>

                       <li class="{{ (Request::is('admin/guidanceCounselors')  || Request::is('admin/guidanceCounselors/*')? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.guidanceCounselors')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="Analytics">
                                   {{ trans("general.guidance_counselors") }}
                               </span>
                           </a>
                       </li>

                       <li class="{{ (Request::is('admin/parents') || Request::is('admin/parents/*') ? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.parents')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="eCommerce">
                                   {{ trans("general.Parents") }}
                               </span>
                           </a>
                       </li>

                       <li class="{{ (Request::is('admin/students') || Request::is('admin/students/*') ? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.students')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate">
                                   {{ trans("general.students") }}
                               </span>
                           </a>
                       </li>
                   </ul>
               </li>
               @endcan
               @can('viewAny', App\Models\Role::class)
               <li class=" nav-item">
                   <a class="d-flex align-items-center" href="#">
                       <i data-feather="shield"></i>
                       <span class="menu-title text-truncate" data-i18n="Roles &amp; Permission">
                           {{ trans("general.Roles") }} &amp; {{ trans("general.Permission") }}
                       </span>
                   </a>
                   <ul class="menu-content">
                       <li class="{{ (Request::is('admin/roles') || Request::is('admin/roles/*') ? 'active' : '') }}">
                           <a class="d-flex align-items-center" href="{{route('admin.roles')}}">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="Roles">
                                   {{ trans("general.Roles") }}
                               </span>
                           </a>
                       </li>
                       <!-- <li>
                           <a class="d-flex align-items-center" href="app-access-permission.html">
                               <i data-feather="circle"></i>
                               <span class="menu-item text-truncate" data-i18n="Permission">
                                   Permission
                                </span>
                            </a>
                       </li> -->
                   </ul>
               </li>
               @endcan
               @can('viewAny', App\Models\Role::class)
               <li class="navigation-header ">
                   <span>
                       {{trans('general.schools_structure')}}
                   </span>
                   <i data-feather="more-horizontal"></i>
               </li>
               @endcan
               @can('viewAny', App\Models\Semester::class)
               <li class=" nav-item {{ (Request::is('admin/semesters') || Request::is('admin/semesters/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.semesters')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.semesters')}}</span>
                   </a>
               </li>
               @endcan
               @can('viewAny', App\Models\AcademicYear::class)
               <li class=" nav-item {{ (Request::is('admin/years/academic') || Request::is('admin/years/academic/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.academicYears')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.academic_years')}}</span>
                   </a>
               </li>
               @endcan
               @can('viewAny', App\Models\Stage::class)
               <li class=" nav-item {{ (Request::is('admin/stages') || Request::is('admin/stages/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.stages')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.stages')}}</span>
                   </a>
               </li>
               @endcan
               @can('viewAny', App\Models\Level::class)
               <li class=" nav-item {{ (Request::is('admin/levels') || Request::is('admin/levels/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.levels')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.levels')}}</span>
                   </a>
               </li>
               @endcan
               @can('viewAny', App\Models\Division::class)
               <li class=" nav-item {{ (Request::is('admin/divisions') || Request::is('admin/divisions/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.divisions')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.divisions')}}</span>
                   </a>
               </li>
               @endcan

               <li class=" nav-item {{ (Request::is('admin/studyMaterials') || Request::is('admin/studyMaterials/*') ? 'active' : '') }}">
                   <a class="d-flex align-items-center" href="{{route('admin.studyMaterials')}}">
                       <i data-feather='layers'></i>
                       <span class="menu-title text-truncate">{{trans('general.studyMaterials')}}</span>
                   </a>
               </li>
           </ul>
       </div>
   </div>
   <!-- END: Main Menu-->