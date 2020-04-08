@if(Session::has('userType'))
<script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({'accountType': '{{ ucfirst(Session::get('userType'))}}' });
</script>
@endif
