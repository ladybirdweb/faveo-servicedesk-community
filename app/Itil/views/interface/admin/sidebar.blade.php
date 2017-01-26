<center><a href="{{url('admin')}}"><li class="header"><span style="font-size:1.5em;">{{ Lang::get('lang.admin_panel') }}</span></li></a></center>
<li class="header">{!! Lang::get('lang.settings-2') !!}</li>
<li class="treeview">
    <a  href="#">
        <i class="fa fa-users"></i> <span>{!! Lang::get('lang.staffs') !!}</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('agents')><a href="{{ url('agents') }}"><i class="fa fa-user "></i>{!! Lang::get('lang.agents') !!}</a></li>
        <li @yield('departments')><a href="{{ url('departments') }}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.departments') !!}</a></li>
        <li @yield('teams')><a href="{{ url('teams') }}"><i class="fa fa-users"></i>{!! Lang::get('lang.teams') !!}</a></li>
        <li @yield('groups')><a href="{{ url('groups') }}"><i class="fa fa-users"></i>{!! Lang::get('lang.groups') !!}</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-envelope-o"></i>
        <span>{!! Lang::get('lang.email') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('emails')><a href="{{ url('emails') }}"><i class="fa fa-envelope"></i>{!! Lang::get('lang.emails') !!}</a></li>
        <li @yield('ban')><a href="{{ url('banlist') }}"><i class="fa fa-ban"></i>{!! Lang::get('lang.ban_lists') !!}</a></li>
        <li @yield('template')><a href="{{ url('template-sets') }}"><i class="fa fa-mail-forward"></i>{!! Lang::get('lang.templates') !!}</a></li>
        <li @yield('email')><a href="{{url('getemail')}}"><i class="fa fa-at"></i>{!! Lang::get('lang.email-settings') !!}</a></li>
        <li @yield('diagnostics')><a href="{{ url('getdiagno') }}"><i class="fa fa-plus"></i>{!! Lang::get('lang.diagnostics') !!}</a></li>
        <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Auto Response</a></li> -->
        <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Rules/a></li> -->
        <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Breaklines</a></li> -->
        <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Log</a></li> -->
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa  fa-cubes"></i>
        <span>{!! Lang::get('lang.manage') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('help')><a href="{{url('helptopic')}}"><i class="fa fa-file-text-o"></i>{!! Lang::get('lang.help_topics') !!}</a></li>
        <li @yield('sla')><a href="{{url('sla')}}"><i class="fa fa-clock-o"></i>{!! Lang::get('lang.sla_plans') !!}</a></li>
        <li @yield('forms')><a href="{{url('forms')}}"><i class="fa fa-file-text"></i>{!! Lang::get('lang.forms') !!}</a></li>
        <li @yield('workflow')><a href="{{url('workflow')}}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.workflow') !!}</a></li>
    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-cog"></i>
        <span>{!! Lang::get('lang.settings') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('company')><a href="{{url('getcompany')}}"><i class="fa fa-building"></i>{!! Lang::get('lang.company') !!}</a></li>
        <li @yield('system')><a href="{{url('getsystem')}}"><i class="fa fa-laptop"></i>{!! Lang::get('lang.system') !!}</a></li>
        <li @yield('tickets')><a href="{{url('getticket')}}"><i class="fa fa-file-text"></i>{!! Lang::get('lang.ticket') !!}</a></li>
        <li @yield('auto-response')><a href="{{url('getresponder')}}"><i class="fa fa-reply-all"></i>{!! Lang::get('lang.auto_response') !!}</a></li>
        <li @yield('alert')><a href="{{url('getalert')}}"><i class="fa fa-bell"></i>{!! Lang::get('lang.alert_notices') !!}</a></li>
        <li @yield('languages')><a href="{{url('languages')}}"><i class="fa fa-language"></i>{!! Lang::get('lang.language') !!}</a></li>
        <li @yield('cron')><a href="{{url('job-scheduler')}}"><i class="fa fa-hourglass"></i>{!! Lang::get('lang.cron') !!}</a></li>
        <li @yield('security')><a href="{{url('security')}}"><i class="fa fa-lock"></i>{!! Lang::get('lang.security') !!}</a></li>
        <li @yield('status')><a href="{{url('setting-status')}}"><i class="fa fa-plus-square-o"></i>{!! Lang::get('lang.status') !!}</a></li>
        <li @yield('notification')><a href="{{url('settings-notification')}}"><i class="fa fa-bell"></i>{!! Lang::get('lang.notifications') !!}</a></li>
        <li @yield('ratings')><a href="{{url('getratings')}}"><i class="fa fa-star"></i>{!! Lang::get('lang.ratings') !!}</a></li>
        <li @yield('close-workflow')><a href="{{url('close-workflow')}}"><i class="fa fa-sitemap"></i>{!! Lang::get('lang.close-workflow') !!}</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-heartbeat"></i>
        <span>{!! Lang::get('lang.error-debug') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <!-- <li @yield('error-logs')><a href="{{ route('error.logs') }}"><i class="fa fa-list-alt"></i> {!! Lang::get('lang.view-logs') !!}</a></li> -->
        <li @yield('debugging-option')><a href="{{ route('err.debug.settings') }}"><i class="fa fa-bug"></i> {!! Lang::get('lang.debug-options') !!}</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-pie-chart"></i>
        <span>{!! Lang::get('lang.widgets') !!}</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li @yield('widget')><a href="{{ url('widgets') }}"><i class="fa fa-list-alt"></i> {!! Lang::get('lang.widgets') !!}</a></li>
        <li @yield('socail')><a href="{{ url('social-buttons') }}"><i class="fa fa-cubes"></i> {!! Lang::get('lang.social') !!}</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="{{ url('plugins') }}">
        <i class="fa fa-plug"></i>
        <span>{!! Lang::get('lang.plugin') !!}</span>
    </a>
</li>
<li class="treeview">
    <a href="{{ url('api') }}">
        <i class="fa fa-cogs"></i>
        <span>{!! Lang::get('lang.api') !!}</span>
    </a>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-sitemap"></i> <span>Asset Management ‎</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li class=""><a href="{{url('service-desk/products')}}"><i class="fa fa-industry"></i>Products</a></li>
        <li class=""><a href="{{url('service-desk/procurement')}}"><i class="fa fa-phone"></i>Procurement Types</a></li>
        <li class=""><a href="{{url('service-desk/contracts')}}"><i class="fa fa-paperclip"></i>Contracts</a></li>
        <li class=""><a href="{{url('service-desk/contract-types')}}"><i class="fa fa-paper-plane"></i>Contracts Types</a></li>
        <li class=""><a href="{{url('service-desk/license-types')}}"><i class="fa fa-paste"></i>License Types</a></li>
        <li class=""><a href="{{url('service-desk/vendor')}}"><i class="fa fa-barcode"></i>Vendors</a></li>
        <li class=""><a href="{{url('service-desk/assetstypes')}}"><i class="fa fa-briefcase"></i>Asset Types</a></li>
        <li class=""><a href="{{url('service-desk/form-builder')}}"><i class="fa fa-folder"></i>Form Builder</a></li>
        <li class=""><a href="{{url('service-desk/cabs')}}"><i class="fa fa-users"></i>Cabs</a></li>
        <li class=""><a href="{{url('service-desk/location-types')}}"><i class="fa fa-map"></i>Locations</a></li>
        <li class=""><a href="{{url('service-desk/location-category-types')}}"><i class="fa fa-map-signs"></i>Location Category</a></li>

    </ul>
</li>