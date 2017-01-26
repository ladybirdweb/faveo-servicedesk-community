<ul class="nav navbar-nav navbar-left"> 
    <li class="">
        <a href="{{url('service-desk/problems')}}">
            <i class="fa fa-bug"></i> 
            <span style="">Problems</span> 
        </a>
    </li> 
    <li>
        <a href="{{url('service-desk/changes')}}">
            <i class="fa fa-refresh"></i> 
            <span style="">Changes</span> 
        </a>



    </li> 

    <li>
        <a href="{{url('service-desk/releases')}}">
            <i class="fa fa-newspaper-o"></i> 
            <span style="">Releases</span> 
        </a>




    </li> 


<!--    <li>

        <a href="{{url('service-desk/assets')}}">
            <i class="fa fa-server"></i> 
            <span style=""> Assets</span> 
        </a>

    </li>-->

<!--    <li>
        <a href="{{url('service-desk/contracts')}}">
            <i class="fa fa-paperclip"></i> 
            <span style=""> Contracts</span> 
        </a>


    </li>-->
    <li class="hidden-xs dropdown" id="newdiv">
        <a class="dropdown-toggle" data-toggle="dropdown" title="New">
            <i class="glyphicon glyphicon-plus" style="font-size:10px;"></i> New<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">

            <li>
                <a href="{{url('service-desk/problem/create')}}">Problems</a>
            </li>
            <li>
                <a href="{{url('service-desk/changes/create')}}">Changes</a>
            </li>
            <li>
                <a href="{{url('service-desk/releases/create')}}">Releases</a>
            </li>
<!--            <li>
                <a href="{{url('service-desk/assets/create')}}">Assets</a>
            </li>-->
<!--            <li>
                <a href="{{url('service-desk/contracts/create')}}">Contracts</a>
            </li>-->

        </ul>
    </li>
</ul>