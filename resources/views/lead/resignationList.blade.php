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
                  <th>Lead Name</th>
                  <th>DOR</th>
                  <th>DOL</th>
                  <th>Status</th>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>Software Engineer</td>
                  <td>Nagalingam</td>
                  <td>11-7-2014</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-success">Completed</span></td>
                </tr>
                <tr>
                <td>183</td>
                  <td>John Doe</td>
                  <td>Software Engineer</td>
                  <td>Nagalingam</td>
                  <td>11-7-2014</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-warning">In progress</span></td>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>Software Engineer</td>
                  <td>Nagalingam</td>
                  <td>11-7-2014</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-primary">New</span></td>
                </tr>
                <tr>
                  <td>183</td>
                  <td>John Doe</td>
                  <td>Software Engineer</td>
                  <td>Nagalingam</td>
                  <td>11-7-2014</td>
                  <td>11-7-2014</td>
                  <td><span class="label label-danger">Withdrawn</span></td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</div>
@endsection
