
<li class="treeview">
    <a href="{{url('dashboard')}}">
        <i class="fa fa-dashboard"></i> 
        <span style="margin-left:-2%;">Dashboard</span> 
    </a>
</li>
<li class="treeview ">
    <a href="#">
        <i class="fa fa-user"></i> <span>Tickets</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu " >
        <li><a href="{{url('ticket/inbox')}}"><i class="fa fa-circle-o"></i>Inbox</a></li>
        <li><a href="{{url('ticket/open')}}"><i class="fa fa-circle-o"></i> open</a></li>
        <li><a href="{{url('ticket/answered')}}"><i class="fa fa-circle-o"></i>Answered</a></li>
        <li><a href="{{url('ticket/myticket')}}"><i class="fa fa-circle-o"></i>My Tickets </a></li>
        <li><a href="{{url('ticket/assigned')}}"><i class="fa fa-circle-o"></i>Assigned </a></li>
        <li><a href="{{url('ticket/closed')}}"><i class="fa fa-circle-o"></i>Closed </a></li>
        <li><a href="{{url('newticket')}}"><i class="fa fa-circle-o"></i>Create Ticket</a></li>
    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-users"></i> <span>	Users</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('user')}}"><i class="fa fa-circle-o"></i> User Directory</a></li>
        <li class=""><a href="{{url('organizations')}}"><i class="fa fa-circle-o"></i>Organization</a></li>
        <li class=""><a href="{{url('user-export')}}"><i class="fa fa-circle-o"></i>Export Users</a></li>
    </ul>
</li>





<li class="treeview">
    <a href="#">
        <i class="fa fa-wrench"></i> <span>	Tools</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu ">
        <li><a href="{{url('canned/list')}}"><i class="fa fa-circle-o"></i> Canned Response</a></li>
        <li class=""><a href="{{url('comment')}}"><i class="fa fa-circle-o"></i>Knowledge Base</a></li>
    </ul>
</li>



<li class="treeview">
    <a href="#">
        <i class="fa fa-bug"></i> <span>Problems</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('service-desk/problems')}}"><i class="fa fa-circle-o"></i> All Problem</a></li>
        <li class=""><a href="{{url('service-desk/problem/create')}}"><i class="fa fa-circle-o"></i>New Problem </a></li>

    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-refresh"></i> <span>Changes</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('service-desk/changes')}}"><i class="fa fa-circle-o"></i> All Changes</a></li>
        <li class=""><a href="{{url('service-desk/changes/create')}}"><i class="fa fa-circle-o"></i>New Changes </a></li>

    </ul>
</li>

<li class="treeview">
    <a href="#">
        <i class="fa fa-newspaper-o"></i> <span>Releases</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('service-desk/releases')}}"><i class="fa fa-circle-o"></i> All Releases</a></li>
        <li class=""><a href="{{url('service-desk/releases/create')}}"><i class="fa fa-circle-o"></i>New Releases </a></li>

    </ul>
</li>
<li class="treeview">
    <a href="#">
        <i class="fa fa-server"></i> <span>Assets</span> <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
        <li><a href="{{url('service-desk/assets')}}"><i class="fa fa-circle-o"></i> All Assets</a></li>
        <li class=""><a href="{{url('service-desk/assets/create')}}"><i class="fa fa-circle-o"></i>New Assets </a></li>
        <li><a href="{{url('service-desk/assets/export')}}"><i class="fa fa-circle-o"></i> Export Assets</a></li>
        
    </ul>
</li>


