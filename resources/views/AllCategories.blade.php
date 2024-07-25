@extends("layouts.layout");
@section("title" ,"All Categories") ;

@section("content")
<div class="col-12">
    @include("layouts.message");

    <div class="card">

              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped text-center align-items-center">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Image</th>
                    <th>Operation</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $cat )
                    <tr>
                    <td class="align-middle">{{ $cat->cat_id }}</td>
                    <td class="align-middle">{{ $cat->name }}</td>
                    <td class="align-middle">
                        <img class="mt-3 ms-3 productImg"  width="170" src="{{ url("images/categories/".$cat->cat_img) }}" alt="more_imgs">

                    </td>
                    <td class="align-middle"    >
                        <a class="btn btn-primary" href="{{ route("category.edit",$cat->cat_id) }}">
                            Edit
                        </a>

                        <form class="d-inline" action="{{ route("category.delete",$cat->cat_id) }}" method="post" >
                            @csrf
                            @method("delete")
                            <button type="submit" class="btn btn-danger" > Delete </button>
                        </form>
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
