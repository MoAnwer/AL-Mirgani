@session($type)
    <div class="mx-3 alert alert-{{ $type == 'message' ? 'success' : 'danger' }} text-black mt-5">{{ session($type) }}</div>
@endsession