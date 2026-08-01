       
        <!-- App js -->
        <script src="{{ URL::asset('assets/js/app.js')}}"></script>


        {{-- SweetAlert2 popup for flash messages --}}
        @if(session('error') || session('success'))
        <script>
            (function() {
                var errorMsg   = '{{ addslashes(session('error')) }}';
                var successMsg = '{{ addslashes(session('success')) }}';
                var msg        = errorMsg || successMsg;
                var isError    = !!errorMsg;

                function showPopup() {
                    if (typeof Swal === 'undefined') {
                        // SweetAlert2 not loaded on this page → load from CDN
                        var script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                        script.onload = function() {
                            Swal.fire({
                                icon: isError ? 'error' : 'success',
                                title: isError ? 'Access Denied' : 'Success',
                                text: msg,
                                confirmButtonText: 'OK'
                            });
                        };
                        script.onerror = function() {
                            alert((isError ? 'Error: ' : 'Success: ') + msg);
                        };
                        document.head.appendChild(script);
                    } else {
                        Swal.fire({
                            icon: isError ? 'error' : 'success',
                            title: isError ? 'Access Denied' : 'Success',
                            text: msg,
                            confirmButtonText: 'OK'
                        });
                    }
                }

                // Run when DOM is ready (works with or without jQuery)
                if (typeof $ !== 'undefined') {
                    $(document).ready(showPopup);
                } else {
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', showPopup);
                    } else {
                        showPopup();
                    }
                }
            })();
        </script>
        @endif


    </body>
</html>