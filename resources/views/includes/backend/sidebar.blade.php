<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="{{ route_is('dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
                </li>

                <li class=""> 
                    <a href="{{route('leads')}}"><i class="la la-user-secret"></i> <span>Leads</span></a>
                </li>

                <li class=""> 
                    <a href="{{ route('billing-invoice') }}"><i class="la la-files-o"></i> <span>Billing Invoice</span></a>
                </li>
                <li class=""> 
                    <a href="{{ route('add-raduis') }}"><i class="la la-files-o"></i> <span>Add Raduis</span></a>
                </li>
                <li class=""> 
                    <a href="{{route('payment-wallet')}}"><i class="la la-files-o"></i> <span>Payment</span></a>
                </li>
                @can('super-admin')
                <li class="{{ route_is(['contractors','contractors-list']) ? 'active' : '' }} noti-dot">
                    <a href="{{route('contractors')}}"><i class="la la-files-o"></i> <span>Contractors</span></a>
                </li>
                @endcan 
                <li class="{{ route_is('services') ? 'active' : '' }}"> 
                    <a href="{{route('services')}}"><i class="la la-user"></i> <span>Services</span></a>
                </li>
                <li class="{{ route_is('profile') ? 'active' : '' }}"> 
                    <a href="{{route('profile')}}"><i class="la la-user"></i> <span>Profile</span></a>
                </li>
                <li class=""> 
                    <a href="{{ route("support") }}"><i class="la la-files-o"></i> <span>Support</span></a>
                </li>
                {{-- <li class=""> 
                    <a href="{{route('logout')}}"><i class="la la-files-o"></i> <span>Logout</span></a>
                </li>
                
                <form action="{{route('logout')}}" method="post" class="la la-files-o">
                    @csrf
                    <button type="submit" class="dropdown-item" >Logout</button>
                </form> --}}

                <li class=""> 
                    <form action="{{route('logout')}}" method="post">
                      @csrf
                      <button type="submit" class="btn btn-link" style="text-decoration:none; color: #b7c0cd;">
                        <i class="la la-files-o" style="font-size:1.5rem; margin-right:0.7rem;"></i> Logout
                      </button>
                    </form>
                  </li>
                
                
                
                

                                
                
                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
