@extends("layouts.layout");
@section("title" ,"Order Detalis") ;

@section("content")
<div class="col-12">
    @include("layouts.message")
    <h2>Total Price : {{ $order->total }}</h2>
    <h2>Order Date  : {{ $order->created_at }}</h2>
    <hr>
    <h4 class="text-center"> All products </h4>
    <table class="table text-center" >
        <thead>
            <th> Product Name </th>
            <th> Product Price </th>
            <th> Product Quantity </th>
            <th> Product img </th>
            <th> Operation  </th>
        </thead>
        <tbody>
            @foreach ( $allproducts as $product )
            <tr>
                <td class="align-middle"> {{ $product['data']->name}} </td>
                <td class="align-middle"> {{ $product['data']->price }} </td>
                <td class="align-middle"> {{ $product['quantity'] }} </td>
                <td class="align-middle" >
                    <img  class="mt-3 ms-3 productImg" height="100"  width="130" src="{{ url("images/products/main_imgs/".$product['data']->main_img) }}" alt="more_imgs">
                </td>
                <td class="align-middle" > <a class="btn btn-primary" href="{{ route("product.edit",$product['data']->id) }}">
                            View Product
                        </a>
                 </td>
            </tr>
            @endforeach
        </tbody>
    </table>

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
