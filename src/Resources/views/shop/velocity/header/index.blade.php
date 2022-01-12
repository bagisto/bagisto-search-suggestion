<header class="sticky-header">
    <div class="row remove-padding-margin velocity-divide-page">
        <logo-component add-class="navbar-brand"></logo-component>
        <searchbar-component></searchbar-component>
    </div>
</header>

@push('scripts')
    <script type="text/javascript">
        (() => {
            document.addEventListener('scroll', e => {
                scrollPosition = Math.round(window.scrollY);

                if (scrollPosition > 50){
                    document.querySelector('header').classList.add('header-shadow');
                } else {
                    document.querySelector('header').classList.remove('header-shadow');
                }
            });
        })()
    </script>
@endpush
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
      $(document).mouseup(function(e){
        var container = $(".form-control");
            if(!container.is(e.target) && container.has(e.target).length === 0){
                $('.suggests').hide();
                    }else{
                $('.suggests').show();
              }
    });

    
});
</script>
@endpush
