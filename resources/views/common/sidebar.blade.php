<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
    <!-- For Lead, Head, HR, SA -->
    @if(in_array(\Auth::User()->emp_id, $headId) || in_array(\Auth::User()->emp_id, $leadId))
    <li class=" {{ (request()->segment(1) == 'process') ? 'active' : '' }}">
        <a href="{{ route('process.index')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    @else
    <!-- For employees -->
    <li data-toggle="tooltip" data-placement="right" @if($myResignation) title= 'Applied Already' style="cursor: not-allowed;" @endif class=" {{ ((request()->segment(1) == 'resignation') && (request()->segment(2) == 'create')) ? 'active' : '' }}">
        <a class="{{ ($myResignation != NULL) ? 'isDisabled' : ' ' }}" href="{{ route('resignation.create')}}">
        <i class="fa fa-file-text-o"></i> <span>Resignation Form</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' style="cursor: not-allowed;" @endif class=" {{ ((request()->segment(1) == 'resignation') && (request()->segment(2) == NULL)) ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('resignation.index')}}">
        <i class="fa fa-list-alt"></i> <span>My Resignation</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' style="cursor: not-allowed;" @endif class=" {{ (request()->segment(1) == 'acceptanceStatus') ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('acceptanceStatus')}}">
        <i class="fa fa-check-square-o"></i> <span>Acceptance Details</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' style="cursor: not-allowed;" @endif class=" {{ ((request()->segment(1) == 'noDueStatus') || (request()->segment(1) == 'questions') ) ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('noDueStatus')}}">
        <i class="fa fa-check-circle-o"></i> <span>No Due Status</span>
        </a>
    </li>
    <li data-toggle="tooltip" data-placement="right" @if(!$myResignation) title= 'Apply resignation to enable' style="cursor: not-allowed;" @endif class=" {{ (request()->segment(1) == 'withdrawForm') ? 'active' : '' }}">
        <a class="{{ ($myResignation == NULL) ? 'isDisabled' : ' ' }}" href="{{ route('withdrawForm')}}">
        <i class="fa fa-file-text-o"></i> <span>Withdraw Form</span>
        </a>
    </li>
    @endif
    <!-- Exit interview sidebar only for HR -->
    @if(Auth::User()->department_id == 2)
    <li class=" {{ ((request()->segment(1) == 'questions') || (request()->segment(1) == 'addquestions') ) ? 'active' : '' }} ">
        <a href="{{ route('questions.index')}}">
        <i class="fa fa-comments"></i> <span>Exit Interview</span>
        </a>
    </li>
    <li class=" {{ (request()->segment(1) == 'workflow') ? 'active' : '' }} ">
        <a href="{{ route('workflow')}}">
        <i class="fa fa-comments"></i> <span>Work Flow</span>
        </a>
    </li>
    @endif

    </ul>
</section>
