<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-accordion menu-shadow menu-light" data-scroll-to-active="true">
    <div class="navbar-header">
       <ul class="nav navbar-nav flex-row">
          <li class="nav-item me-auto">
             <a class="navbar-brand" href="{{url('/')}}">
                <span class="brand-logo">
                <img src="{{asset('app-assets/images/logo/favicon.png')}}" style="width:50px">
                </span>
                <h2 class="brand-text">QED Group</h2>
             </a>
          </li>
          <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
             class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
             class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
             data-ticon="disc"></i></a></li>
       </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content ps ps--active-y">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          <li class="nav-item   mt-3 @if(URL::current() == route('home')) active  @endif"><a class="d-flex align-items-center" href="{{route('home')}}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>

          </li>

          {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('restaurants.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span class="menu-title text-truncate" data-i18n="Email">Restaurants</span></a>
          </li> --}}
          <li @if(URL::current() == route('documents.create')) class="active" @endif>
            <a class="d-flex align-items-center " href="{{route('documents.create')}}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg><span class="menu-item text-truncate" data-i18n="List">Documents</span></a>
          </li>
          <li @if(URL::current() == route('advance.filter')) class="active" @endif>
            <a class="d-flex align-items-center " href="{{route('advance.filter')}}"><i class="fa fa-filter"></i><span class="menu-item text-truncate" data-i18n="filter">Advance Filter</span></a>
          </li>
          {{-- <li class="nav-item has-sub"><a class="d-flex align-items-center" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span class="menu-title text-truncate" data-i18n="Invoice">Documents</span></a>
            <ul class="menu-content">
                <li>
                    <a class="d-flex align-items-center" href="{{route('documents.create')}}"><i class="fa fa-plus"></i><span class="menu-item text-truncate" data-i18n="List"><strong>Add Document</strong></span></a>
                </li>
                @forelse (documentTypes() as $item)
                    <li>
                        <a class="d-flex align-items-center" href="{{route('documentType',$item->id)}}"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg><span class="menu-item text-truncate" data-i18n="List">{{$item->name}}</span></a>
                    </li>
                @empty

                @endforelse
            </ul>
          </li> --}}
          {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="{{route('users.index')}}">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
              <span class="menu-title text-truncate" data-i18n="File Manager">Users</span></a>
          </li> --}}
          {{-- <li class="nav-item has-sub"><a class="d-flex align-items-center" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg><span class="menu-title text-truncate" data-i18n="Roles &amp; Permission">Roles &amp; Permission</span></a>
            <ul class="menu-content">
              <li><a class="d-flex align-items-center" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg><span class="menu-item text-truncate" data-i18n="Roles">Roles</span></a>
              </li>
              <li><a class="d-flex align-items-center" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg><span class="menu-item text-truncate" data-i18n="Permission">Permission</span></a>
              </li>
            </ul>
          </li> --}}
        </ul>
      <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 1027px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 580px;"></div></div></div>
 </div>
 <!-- END: Main Menu-->
