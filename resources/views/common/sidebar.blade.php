<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <li>
        <a href="{{ route('resignation.create')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->designation == 'Software Engineer')
    <li>
        <a href="{{ route('resignation.index')}}">
        <i class="fa fa-list-alt"></i> <span>My Resignation</span>
        </a>
    </li>
    <li>
        <a href="{{ route('acceptanceStatus')}}">
        <i class="fa fa-tasks"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li>
        <a href="{{ route('withdrawForm')}}">
        <i class="fa fa-file-text-o"></i> <span>Withdraw Form</span>
        </a>
    </li>
    @endif
    </ul>
</section>