@extends('layouts.app_home')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Employee Resignation List</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                    </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Employee ID</th>
                  <th>Employee Name</th>
                  <th>Designation</th>
                  <th>DOR</th>
                  <th>DOL</th>
                  <th>Status</th>
                  <th>View</th>
                  @if(Auth::user()->designation == 'Head')
                  <th>&nbsp;&nbsp;&nbsp;&nbsp; Assign Lead</th>
                  @endif
                </tr>
                @foreach($emp_list as $emp)
                <tr>
                  <td>{{ $emp->user_id }}</td>
                  <td>{{ $emp->name }}</td>
                  <td>{{ $emp->designation }}</td>
                  <td>{{ $emp->date_of_resignation }}</td>
                  <td>{{ ($emp->changed_dol == NULL) ? $emp->date_of_leaving : $emp->changed_dol }}</td>
                  <td><span class="label {{ ($emp->date_of_withdraw != NULL) ? 'label-danger' : 'label-primary'}}">{{ ($emp->date_of_withdraw != NULL) ? 'Withdrawn' : 'New'}}</span></td>
                  <td><a href="{{ route('process.edit', $emp->id )}}">View</a></td>
                  @if(Auth::user()->designation == 'Head')
                  <td>
                    @if($emp->lead == NULL)
                    <form method="post" action="{{ route('process.update' , $emp->user_id ) }}">
                      @csrf
                      {{ method_field('PUT') }}
                      <div class="form-group">
                        <div class="col-sm-6">
                        <select class="form-control" name="lead" id="lead">
                          <option value="">Select</option>
                          @foreach($lead_list as $lead)
                          <option value="{{ $lead->name }}">{{ $lead->name }}</option>
                          @endforeach
                        </select>
                        </div>
                        <div class="col-sm-1">
                          <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                      </div>
                    </form>
                    @endif
                    {{ $emp->lead }}
                  </td>
                  @endif
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</div>
@endsection
