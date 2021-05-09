<div class="card ">
    <div class="card-header  ">
        <h5 class="lead mt-3 mb-3"><i class="fa fa-cog "></i> Account Setting</h5>
    </div>


    <ul class="list-group ">


        <li class="list-group-item sidebar-item py-3">
            <a href="{{route('user.profile')}}" class="sidebar-link ">
                <h6 class=" lead"> <img class="rounded-circle" src="{{auth()->user()->avatar}}"
                        width="28" height="28"> Your Profile</h6>
            </a>
        </li>
        <li class="list-group-item sidebar-item py-3">
            <a href="{{route('user.orders')}}" class="sidebar-link">
                <h6 class=" lead ml-1"> <i class="fa fa-shopping-basket text-secondary"></i> Your Orders</h6>
            </a>
        </li>
        <li class="list-group-item sidebar-item py-3">
            <a href="{{route('cart')}}" class="sidebar-link">
                <h6 class=" lead ml-1"> <i class="fa fa-shopping-cart text-success"></i> Your Cart</h6>
            </a>
        </li>
        <li class="list-group-item sidebar-item py-3">
            <a href="{{route('user.password.edit')}}" class="sidebar-link">
                <h6 class=" lead ml-2"> <i class="fa fa-edit text-info"></i> Change Password</h6>
            </a>
        </li>
        <li class="list-group-item sidebar-item py-3">
            <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="{{route('logout')}}" class="sidebar-link" onclick="event.preventDefault();
            document.getElementById('logout-form2').submit();">
                <h6 class=" lead ml-2"> <i class="fa fa-power-off text-danger"></i> Logout</h6>
            </a>
        </li>

    </ul>


</div>