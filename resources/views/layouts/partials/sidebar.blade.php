<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="row">
        {{-- <iframe scrolling="no" frameborder="no" clocktype="html5" src="http://www.clocklink.com/html5embed.php?clock=024&timezone=GMT0600&color=black&size=150&Title=&Message=&Target=&From=2016,1,1,0,0,0&Color=black"></iframe> --}}
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">@if(Auth::user()->hasAnyRole('Admin') == true) Admin @else User @endif's Adminstration</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ url('attendence') }}"><i class='fa fa-calendar'></i> <span>Attendence</span></a></li>
            @if(Auth::user()->hasAnyRole('Admin') == true)
            <li class="treeview">
                <a href="#"><i class='fa fa-cog'></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('settings.attendence')}}">Attendence</a></li>
                </ul>
                <ul class="treeview-menu">
                    <li><a href="{{route('settings.acl')}}">Access Control</a></li>
                </ul>
            </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
