@extends("layouts.layout");
@section("title" ,"All Orders") ;

@section("content")
<div class="col-12">
    @include("layouts.message");

    <div class="card">

              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center">
                  <thead>
                  <tr>
                    <th>Order Id</th>
                    <th> Customer Id </th>
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Order Date </th>
                    <th>Operation</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $order )
                    <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_id }}</td>
                    <td>{{ $customer_names[$order->customer_id] }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ route("order.detalis",$order->id) }}">
                            View Detalis
                        </a>

                    </td>
                  </tr>

                    @endforeach



                  </tbody>

                </table>
              </div>
              <!-- /.card-body -->
</div>
</div>
@endsection
@section("css")
    <link rel="stylesheet" href="{{ url("lugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
  <link rel="stylesheet" href="{{url("lugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
  <link rel="stylesheet" href="{{url("lugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endsection;
@section("js")
    <script src="{{  url("plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
    <script src="{{  url("plugins/jszip/jszip.min.js")}}"></script>
    <script src="{{  url("plugins/pdfmake/pdfmake.min.js")}}"></script>
    <script src="{{  url("plugins/pdfmake/vfs_fonts.js")}}"></script>
    <script src="{{  url("plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
    <script src="{{  url("plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
    <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  });
</script>
@endsection;
