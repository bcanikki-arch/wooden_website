<script src="{{ url('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ url('assets/js/feather.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ url('assets/plugins/apexchart/chart-data.js') }}"></script>
<script src="{{ url('assets/plugins/chartjs/chart.min.js') }}"></script>
<script src="{{ url('assets/plugins/chartjs/chart-data.js') }}"></script>
<script src="{{ url('assets/js/moment.min.js') }}"></script>
<script src="{{ url('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ url('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ url('assets/plugins/%40simonwep/pickr/pickr.es5.min.js') }}"></script>
<script src="{{ url('assets/js/theme-colorpicker.js') }}"></script>
<script src="{{ url('assets/js/script.js') }}"></script>
<script src="{{ url('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"></script>
<script src="{{ url('assets/plugins/quill/quill.min.js')}}" ></script>
<script src="{{ url('assets/js/bootstrap-datetimepicker.min.js')}}" ></script>
<script src="{{ url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}" ></script>
<script src="https://static.cloudflareinsights.com/beacon.min.js"></script>
<script src="{{ url('assets/plugins/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script>
        var textareas = document.getElementsByClassName('ckeditor');
        for (var i = 0; i < textareas.length; i++) {
            var editorId = textareas[i].id;
            CKEDITOR.replace(editorId);
        }
    </script>
       <script>
    document.addEventListener('DOMContentLoaded', () => {
        const html = document.documentElement;
        const props = ['primaryColor', 'secondaryColor', 'fontColor', 'backgroundColor'];
        props.forEach(p => {
            const val = html.dataset[p];
            if (val) document.documentElement.style.setProperty(`--${p.replace(/([A-Z])/g, "-$1").toLowerCase()}`, val);
        });
    });
    </script>
    <script>
        
        document.getElementById('logout-link').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out of your session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Logout!'
            }).then((result) => {
                if (result.isConfirmed) {

                    fetch("{{ route('admin.logout') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        },
                    }).then(() => {
                        window.location.href = "{{ url('/login') }}";
                    });
                    Swal.fire(
                        'Logged Out!',
                        'You have been logged out.',
                        'success'
                    )
                }
            })
        });
    </script>
    <!-- jQuery -->

