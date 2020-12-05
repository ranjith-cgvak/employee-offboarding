<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <!-- For Lead, Head, HR, SA -->
    @if((Auth::User()->department_id == 7) || (Auth::User()->department_id == 2) || (Auth::User()->designation_id == 2) || (Auth::User()->designation_id == 3) )
    <li class=" {{ (request()->segment(1) == 'process') ? 'active' : '' }}">
        <a href="{{ route('process.index')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <!-- For employees -->
    @else
    <li data-toggle="tooltip" data-placement="right" @if($myResignation) title= 'Applied Already' @endif class=" {{ ((request()->segment(1) == 'resignation') && (request()->segment(2) == 'create')) ? 'active' : '' }}">
        <a class="{{ ($myResignation != NULL) ? 'isDisabled' : ' ' }}" href="{{ route('resignation.create')}}">
        <i class="fa fa-file-text-o"></i> <span>Resignation Form</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' @endif class=" {{ ((request()->segment(1) == 'resignation') && (request()->segment(2) == NULL)) ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('resignation.index')}}">
        <i class="fa fa-list-alt"></i> <span>My Resignation</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' @endif class=" {{ (request()->segment(1) == 'acceptanceStatus') ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('acceptanceStatus')}}">
        <i class="fa fa-check-square-o"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' @endif class=" {{ (request()->segment(1) == 'noDueStatus') ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('noDueStatus')}}">
        <i class="fa fa-check-square-o"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' @endif class=" {{ (request()->segment(1) == 'withdrawForm') ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('withdrawForm')}}">
        <i class="fa fa-file-text-o"></i> <span>Withdraw Form</span>
        </a>
    </li>
    @endif
    </ul>
</section>