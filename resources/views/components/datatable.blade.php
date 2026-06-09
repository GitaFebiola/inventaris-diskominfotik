<div class="table-responsive">

    {{ $slot }}

</div>

@once

<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

@endonce

@push('scripts')

<script>

$(document).ready(function(){

    var table = $('.datatable').DataTable({

    pageLength: 10,
    ordering: true,
    searching: true,
    responsive: true,
    lengthChange: true,

    language: {
        search: "Cari:",
        lengthMenu: "Tampilkan _MENU_ data",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        emptyTable: "Tidak ada data",
        zeroRecords: "Data tidak ditemukan",
        paginate: {
            previous: "←",
            next: "→"
        }
    },

    columnDefs: [
        {
            targets: 0,
            searchable: false,
            orderable: false
        }
    ]
});

table.on('order.dt search.dt draw.dt', function () {

    let i = 1;

    table.cells(null, 0, { search: 'applied', order: 'applied' })
         .every(function () {

             this.data(i++);

         });

}).draw();

});

</script>

@endpush