@extends('layouts.main')

@section('title')
Notification
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
      </div>
      <div class="col-lg-6 col-5 text-right">
        
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row">
    <!-- Light table -->
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <h3 class="mb-0">Your Notification</h3>
        </div>
        <!-- Light table -->
        <div class="table-responsive">
          <table id="table" class="display table table-striped table-hover" >
            <thead>
            <tr>
                <td style="width: 5%">#</td>
                <td style="width: 20%">Title</td>
                <td style="width: 20%">Content</td>
                <td style="width: 20%">Time</td>
                <th style="width: 20%">Action</th>
            </tr>
            </thead>
            <tbody>
              @foreach (auth()->user()->notifications as $idx=>$notif)
                  <tr>
                    <td>{{ $idx+1 }}</td>
                    <td><a href="{{ $notif->data['url'] ?? "#" }}">{{ $notif->data['title'] }}</a></td>
                    <td>{{ $notif->data['body'] }}</td>
                    <td>{{ $notif->created_at->diffForHumans() }}</td>
                    <td>
                      @if (!$notif->read_at)
                      <form action="{{ route('notification.read', $notif->id) }}" method="post" style="display: inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success"> <i class="fas fa-book"></i></button>
                      </form>
                      @endif
                      <form action="{{ route('notification.delete', $notif->id) }}" method="post" style="display: inline" onsubmit="return confirm('Are you sure to delete this notification?')">
                        @method("DELETE")
                        @csrf
                      <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
      $(document).ready(function() {
        $('#table').DataTable({
        });
      });
    </script>
@endsection

