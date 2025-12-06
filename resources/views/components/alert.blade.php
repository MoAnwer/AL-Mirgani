@session($type)
    <div class="mx-3 d-flex justify-content-between align-items-center alert alert-{{ $type == 'message' ? 'success' : 'danger' }} text-black mt-5">{{ session($type) }}
        <i class="close bx bx-x-circle" title="{{ __('app.close') }}"></i>
    </div>
    <script>
        const close = document.querySelector(".close");
        const alertElement = document.querySelector(".alert");
        setTimeout(() => {
            alertElement.remove();
        }, 3000);
        if (alertElement) {
            close.addEventListener('click', (e) => {
                alertElement.remove();
            });            
        }
    </script>
@endsession