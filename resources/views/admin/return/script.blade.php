@push('js')
    <script>
        $(function() {
            $('#datatable-return').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('return-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },

                    {
                        data: 'foto',
                        name: 'foto'
                    },
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'pesanan.no_invoice',
                        name: 'pesanan.no_invoice'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    },

                ]
            });

            $('.refresh').click(function() {
                $('#datatable-return').DataTable().ajax.reload();
            });

        });
    </script>
@endpush
