@session($type)
    <div class="alert alert-{{ $type == 'message' ? 'success' : 'danger' }} text-black mt-5">{{ session($type) }}</div>
@endsession