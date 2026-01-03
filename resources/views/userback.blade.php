@if(\is_string($accessToken))
<script>
    window.Userback = window.Userback || {};
    Userback.access_token = @js($accessToken);
    @if($userData)
    Userback.user_data = @js($userData);
    @endif
    (function(d) {
        var scriptTag = d.createElement('script');
        scriptTag.async = true;
        scriptTag.src = 'https://static.userback.io/widget/v1.js';
        (d.head || d.body).appendChild(scriptTag);
    })(document);
</script>
@endif
