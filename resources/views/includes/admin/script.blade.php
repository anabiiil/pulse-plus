<!-- Popper JS -->
<script src="https://code.jquery.com/jquery-3.7.0.slim.min.js"
        integrity="sha256-tG5mcZUtJsZvyKAxYLVXrmjKBVLd6VpVccqz/r4ypFE=" crossorigin="anonymous"></script>
<script src="{{asset('assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>

<!-- Bootstrap JS -->
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Defaultmenu JS -->
<script src="{{asset('assets/js/defaultmenu.min.js')}}"></script>

<!-- Node Waves JS-->
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>

<!-- Sticky JS -->
<script src="{{asset('assets/js/sticky.js')}}"></script>

<!-- Simplebar JS -->
<script src="{{asset('/')}}assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{asset('/')}}assets/js/simplebar.js"></script>

<!-- Color Picker JS -->
<script src="{{asset('/')}}assets/libs/@simonwep/pickr/pickr.es5.min.js"></script>


<!-- JSVector Maps JS -->
<script src="{{asset('/')}}assets/libs/jsvectormap/js/jsvectormap.min.js"></script>

<!-- JSVector Maps MapsJS -->
<script src="{{asset('/')}}assets/libs/jsvectormap/maps/world-merc.js"></script>

<!-- Apex Charts JS -->
{{-- <script src="{{asset('/')}}assets/libs/apexcharts/apexcharts.min.js"></script> --}}

<!-- Chartjs Chart JS -->
{{-- <script src="{{asset('/')}}assets/libs/chart.js/chart.min.js"></script> --}}

<!-- CRM-Dashboard -->
{{-- <script src="{{asset('/')}}assets/js/crm-dashboard.js"></script> --}}


<!-- Custom-Switcher JS -->
<script src="{{asset('/')}}assets/js/custom-switcher.min.js"></script>

<!-- Custom JS -->
<script src="{{asset('/')}}assets/js/custom.js"></script>
@livewireScripts
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<x-livewire-alert::scripts />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
    })
</script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script>
    Livewire.on('openModal', id => {
        const truck_modal = document.querySelector(id);
        let myModal = bootstrap.Modal.getOrCreateInstance(truck_modal);
        myModal.show();
    });

    Livewire.on('closeModal', id => {
        const truck_modal = document.querySelector(id);
        const modal = bootstrap.Modal.getOrCreateInstance(truck_modal);
        modal.hide();
    });
    // Livewire.on('renderSelect2', id => {
    //     $('.select2').select2();
    // });

</script>

@stack('js')
