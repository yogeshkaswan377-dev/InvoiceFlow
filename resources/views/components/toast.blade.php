@if(session('success'))
<script>
    Toastify({
        text: "{{ session('success') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: { background: "#22c55e" }
    }).showToast();
</script>
@endif

@if(session('error'))
<script>
    Toastify({
        text: "{{ session('error') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: { background: "#ef4444" }
    }).showToast();
</script>
@endif

@if(session('info'))
<script>
    Toastify({
        text: "{{ session('info') }}",
        duration: 3000,
        gravity: "top",
        position: "right",
        style: { background: "#3b82f6" }
    }).showToast();
</script>
@endif