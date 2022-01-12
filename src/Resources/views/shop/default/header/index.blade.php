<?php
    $term = request()->input('term');
    $image_search = request()->input('image-search');

    if (! is_null($term)) {
        $serachQuery = 'term='.request()->input('term');
    }
?>

<div class="header" id="header">
    <div class="header-top">
        <div class="left-content">
            <ul class="logo-container">
                <li>
                    <a href="{{ route('shop.home.index') }}" aria-label="Logo">
                        @if ($logo = core()->getCurrentChannel()->logo_url)
                            <img class="logo" src="{{ $logo }}" alt="" />
                        @else
                            <img class="logo" src="{{ bagisto_asset('images/logo.svg') }}" alt="" />
                        @endif
                    </a>
                </li>
            </ul>
            <div class="newsearch" style="position:relative;">
            <ul class="search-container">
                <li class="search-group">
                    <form role="search" action="{{ route('shop.search.index') }}" method="GET" style="display: inherit;">
                        <label for="search-bar" style="position: absolute; z-index: -1;">Search</label>
                        <input
                            required
                            name="term"
                            type="search"
                            @keyup="someFunctionRun($event)"
                            value="{{ ! $image_search ? $term : '' }}"
                            class="search-field"
                            id="search-bar"
                            placeholder="{{ __('shop::app.header.search-text') }}"
                        >

                        <image-search-component></image-search-component>

                        <div class="search-icon-wrapper">

                            <button class="" class="background: none;" aria-label="Search">
                                <i class="icon icon-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>
            <div  id="old-new" class="suggest"> </div>
        </div>
</div>
        <div class="right-content">

            <span class="search-box"><span class="icon icon-search" id="search"></span></span>

            <ul class="right-content-menu">

                {!! view_render_event('bagisto.shop.layout.header.comppare-item.before') !!}

                @php
                    $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false
                @endphp

                @if ($showCompare)
                    <li class="compare-dropdown-container">
                        <a
                            @auth('customer')
                                href="{{ route('velocity.customer.product.compare') }}"
                            @endauth

                            @guest('customer')
                                href="{{ route('velocity.product.compare') }}"
                            @endguest
                            style="color: #242424;"
                            >

                            <i class="icon compare-icon"></i>
                            <span class="name">
                                {{ __('shop::app.customer.compare.text') }}
                                <span class="count">(<span id="compare-items-count"></span>)<span class="count">
                            </span>
                        </a>
                    </li>
                @endif

                {!! view_render_event('bagisto.shop.layout.header.compare-item.after') !!}

                {!! view_render_event('bagisto.shop.layout.header.currency-item.before') !!}

                @if (core()->getCurrentChannel()->currencies->count() > 1)
                    <li class="currency-switcher">
                        <span class="dropdown-toggle">
                            {{ core()->getCurrentCurrencyCode() }}

                            <i class="icon arrow-down-icon"></i>
                        </span>

                        <ul class="dropdown-list currency">
                            @foreach (core()->getCurrentChannel()->currencies as $currency)
                                <li>
                                    @if (isset($serachQuery))
                                        <a href="?{{ $serachQuery }}&currency={{ $currency->code }}">{{ $currency->code }}</a>
                                    @else
                                        <a href="?currency={{ $currency->code }}">{{ $currency->code }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                {!! view_render_event('bagisto.shop.layout.header.currency-item.after') !!}


                {!! view_render_event('bagisto.shop.layout.header.account-item.before') !!}

                <li>
                    <span class="dropdown-toggle">
                        <i class="icon account-icon"></i>

                        <span class="name">{{ __('shop::app.header.account') }}</span>

                        <i class="icon arrow-down-icon"></i>
                    </span>

                    @guest('customer')
                        <ul class="dropdown-list account guest">
                            <li>
                                <div>
                                    <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                        {{ __('shop::app.header.title') }}
                                    </label>
                                </div>

                                <div style="margin-top: 5px;">
                                    <span style="font-size: 12px;">{{ __('shop::app.header.dropdown-text') }}</span>
                                </div>

                                <div style="margin-top: 15px;">
                                    <a class="btn btn-primary btn-md" href="{{ route('customer.session.index') }}" style="color: #ffffff">
                                        {{ __('shop::app.header.sign-in') }}
                                    </a>

                                    <a class="btn btn-primary btn-md" href="{{ route('customer.register.index') }}" style="float: right; color: #ffffff">
                                        {{ __('shop::app.header.sign-up') }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                    @endguest

                    @auth('customer')
                        @php
                           $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                        @endphp

                        <ul class="dropdown-list account customer">
                            <li>
                                <div>
                                    <label style="color: #9e9e9e; font-weight: 700; text-transform: uppercase; font-size: 15px;">
                                        {{ auth()->guard('customer')->user()->first_name }}
                                    </label>
                                </div>

                                <ul>
                                    <li>
                                        <a href="{{ route('customer.profile.index') }}">{{ __('shop::app.header.profile') }}</a>
                                    </li>

                                    @if ($showWishlist)
                                        <li>
                                            <a href="{{ route('customer.wishlist.index') }}">{{ __('shop::app.header.wishlist') }}</a>
                                        </li>
                                    @endif

                                    <li>
                                        <a href="{{ route('shop.checkout.cart.index') }}">{{ __('shop::app.header.cart') }}</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('customer.session.destroy') }}">{{ __('shop::app.header.logout') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endauth
                </li>

                {!! view_render_event('bagisto.shop.layout.header.account-item.after') !!}


                {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}

                <li class="cart-dropdown-container">

                    @include('shop::checkout.cart.mini-cart')

                </li>

                {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}

            </ul>

            <span class="menu-box" ><span class="icon icon-menu" id="hammenu"></span>
        </div>
    </div>

    <div class="header-bottom" id="header-bottom">
        @include('shop::layouts.header.nav-menu.navmenu')
    </div>

    <div class="search-responsive mt-10" id="search-responsive">
        <form role="search" action="{{ route('shop.search.index') }}" method="GET" style="display: inherit;">
            <div class="search-content">
                <button style="background: none; border: none; padding: 0px;">
                    <i class="icon icon-search"></i>
                </button>

                <image-search-component></image-search-component>

                <input type="search" name="term" @keyup="someFunctionRun($event)" class="search">
                
                <i class="icon icon-menu-back right"></i>
                
            </div>
            <div  id="old-ne" class="suggest" style="
          
          width:100%;
          z-index:1;
          background-color:white;
          font-size:15px;
          max-height:600px;
          overflow-y:auto;
          ">
           
            </div>     
        </form>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet" defer></script>

    <script type="text/x-template" id="image-search-component-template">
        <div v-if="image_search_status">
            <label class="image-search-container" :for="'image-search-container-' + _uid">
                <i class="icon camera-icon"></i>

                <input type="file" :id="'image-search-container-' + _uid" ref="image_search_input" v-on:change="uploadImage()"/>

                <img :id="'uploaded-image-url-' +  + _uid" :src="uploaded_image_url" alt="" width="20" height="20" />
            </label>
        </div>
    </script>

    <script>

        Vue.component('image-search-component', {

            template: '#image-search-component-template',

            data: function() {
                return {
                    uploaded_image_url: '',
                    image_search_status: "{{core()->getConfigData('general.content.shop.image_search') == '1' ? 'true' : 'false'}}" == 'true'
                }
            },

            methods: {
                uploadImage: function() {
                    var imageInput = this.$refs.image_search_input;

                    if (imageInput.files && imageInput.files[0]) {
                        if (imageInput.files[0].type.includes('image/')) {
                            var self = this;

                            if (imageInput.files[0].size <= 2000000) {
                                self.$root.showLoader();

                                var formData = new FormData();

                                formData.append('image', imageInput.files[0]);

                                axios.post("{{ route('shop.image.search.upload') }}", formData, {headers: {'Content-Type': 'multipart/form-data'}})
                                    .then(function(response) {
                                        self.uploaded_image_url = response.data;

                                        var net;

                                        async function app() {
                                            var analysedResult = [];

                                            var queryString = '';

                                            net = await mobilenet.load();

                                            const imgElement = document.getElementById('uploaded-image-url-' +  + self._uid);

                                            try {
                                                const result = await net.classify(imgElement);

                                                result.forEach(function(value) {
                                                    queryString = value.className.split(',');

                                                    if (queryString.length > 1) {
                                                        analysedResult = analysedResult.concat(queryString)
                                                    } else {
                                                        analysedResult.push(queryString[0])
                                                    }
                                                });
                                            } catch (error) {
                                                self.$root.hideLoader();

                                                window.flashMessages = [
                                                    {
                                                        'type': 'alert-error',
                                                        'message': "{{ __('shop::app.common.error') }}"
                                                    }
                                                ];

                                                self.$root.addFlashMessages();
                                            };

                                            localStorage.searched_image_url = self.uploaded_image_url;

                                            queryString = localStorage.searched_terms = analysedResult.join('_');

                                            self.$root.hideLoader();

                                            window.location.href = "{{ route('shop.search.index') }}" + '?term=' + queryString + '&image-search=1';
                                        }

                                        app();
                                    })
                                    .catch(function(error) {
                                        self.$root.hideLoader();

                                        window.flashMessages = [
                                            {
                                                'type': 'alert-error',
                                                'message': "{{ __('shop::app.common.error') }}"
                                            }
                                        ];

                                        self.$root.addFlashMessages();
                                    });
                            } else {

                                imageInput.value = '';

                                        window.flashMessages = [
                                            {
                                                'type': 'alert-error',
                                                'message': "{{ __('shop::app.common.image-upload-limit') }}"
                                            }
                                        ];

                                self.$root.addFlashMessages();

                            }
                        } else {
                            imageInput.value = '';

                            alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                        }
                    }
                }
            }
        });

    </script>

    <script>
        $(document).ready(function() {

            $('body').delegate('#search, .icon-menu-close, .icon.icon-menu', 'click', function(e) {
                toggleDropdown(e);
            });

            @auth('customer')
                @php
                    $compareCount = app('Webkul\Velocity\Repositories\VelocityCustomerCompareProductRepository')
                        ->count([
                            'customer_id' => auth()->guard('customer')->user()->id,
                        ]);
                @endphp

                let comparedItems = JSON.parse(localStorage.getItem('compared_product'));
                $('#compare-items-count').html({{ $compareCount }});
            @endauth

            @guest('customer')
                let comparedItems = JSON.parse(localStorage.getItem('compared_product'));
                $('#compare-items-count').html(comparedItems ? comparedItems.length : 0);
            @endguest

            function toggleDropdown(e) {
                var currentElement = $(e.currentTarget);

                if (currentElement.hasClass('icon-search')) {
                    currentElement.removeClass('icon-search');
                    currentElement.addClass('icon-menu-close');
                    $('#hammenu').removeClass('icon-menu-close');
                    $('#hammenu').addClass('icon-menu');
                    $("#search-responsive").css("display", "block");
                    $("#header-bottom").css("display", "none");
                } else if (currentElement.hasClass('icon-menu')) {
                    currentElement.removeClass('icon-menu');
                    currentElement.addClass('icon-menu-close');
                    $('#search').removeClass('icon-menu-close');
                    $('#search').addClass('icon-search');
                    $("#search-responsive").css("display", "none");
                    $("#header-bottom").css("display", "block");
                } else {
                    currentElement.removeClass('icon-menu-close');
                    $("#search-responsive").css("display", "none");
                    $("#header-bottom").css("display", "none");
                    if (currentElement.attr("id") == 'search') {
                        currentElement.addClass('icon-search');
                    } else {
                        currentElement.addClass('icon-menu');
                    }
                }
            }
        });
    </script>
@endpush
@push('scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  var url = window.location.toString();
    if(url.match(/%3Cb%3E/gi) == '%3Cb%3E'){
    var urla = url.replace('%3Cb%3E','');
    window.location = urla.replace('%3C/b%3E',''); 
    }
function someFunctionRun(event){
var display_product_toggle= '<?php $hello= core()->getConfigData('suggestion.suggestion.options.display_product_toggle');
                    echo $hello ?>';   
   var no_of_terms = '<?php $hello= core()->getConfigData('suggestion.suggestion.options.show_terms');
                    echo $hello ?>';
      
      var display_terms_toggle ='<?php $hello= core()->getConfigData('suggestion.suggestion.options.display_terms_toggle'); 
                     echo $hello ?>';
         var no_of_products ='<?php $hello= core()->getConfigData('suggestion.suggestion.options.show_products'); 
                     echo $hello ?>';
            var display_terms_number_toggle ='<?php $hello= core()->getConfigData('suggestion.suggestion.options.display_terms_number_toggle'); 
                     echo $hello ?>';
                      var display_category='<?php $hello= core()->getConfigData('suggestion.suggestion.options.display_categories_toggle');
                     echo $hello ?>';

            var term =event.target.value;
            var obj={
                category:'',
                term:term
                };
            $.ajax({
                url:"{{ route('searchsuggestion.search.index') }}",
                type:"get",
                data:obj,
                success:function(data){
                    $('.suggest').html('');
if(term.length !== 0){
    if(data[0].data.length !== 0){
        if(display_category == 1){
              if(data[0].data.length < no_of_terms){
                        for (let index = 0; index < data[0].data.length; index++){
                            if(data[0].data[index].product.categories[0]){
                                if(data[0].data[index].product.categories[0].name == 'Root'){
                                    $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+'</p>'+
                '</div></a>');       
                                }else{
                                    $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+' in '+data[0].data[index].product.categories[0].name+'</p>'+
                '</div></a>');
                                }
                            }else{
                                $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+'</p>'+
                '</div></a>');  
                            }
                         }
                    }else if (data[0].data.length >= no_of_terms) {
                        for (let index = 0; index < no_of_terms; index++){
                            if(data[0].data[index].product.categories[0]){
                                if(data[0].data[index].product.categories[0].name == 'Root'){
                                    $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+'</p>'+
                '</div></a>');       
                                }else{
                                    $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+' in '+data[0].data[index].product.categories[0].name+'</p>'+
                '</div></a>');
                                }
                            }else{
                                $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                'href="'+ data[0].data[index].url_key+'"> <div class="dcategory">'+
                '<p>'+data[0].data[index].name+'</p>'+
                '</div></a>');  
                            }
                }
                    }
                }
                if(display_terms_toggle == 1){
                         $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                         'href="categorysearch?category=&term='+term+'"><div class="terms">'+
                 '<p class="termsa">'+term+'</p>'+
                '<p class="termsb">'+data[0].data.length+'</p>'+
                '</div></a>');
                }
                if(display_product_toggle == 1){
                    $('.suggest').append('<div class="popular">'+
                 '<p>{{ __('suggestion::app.popular_products') }}</p>'+
                '</div>');
                    if (data[0].data.length < no_of_products) {
                        for(let index = 0; index < data[0].data.length; index++) {        
                        $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                        'href="'+ data[0].data[index].url_key+'">'+
                        '<div class="product">'+
                        '<div class="img">'+
                        '<img style="'+
                        'width:100%;'+
                        '" src="'+data[2][index][0].small_image_url+'" >'+
                        '</div>'+
                        '<div class="imgp">'+
                        '<p class="image_name">'+data[0].data[index].name+'</p>'+
                        '<p>'+data[1][index]+'</p>'+
                        '</div></div></a>');
                        }
                    }else if(data[0].data.length >= no_of_products){
                        for (let index = 0; index < no_of_products; index++) {            
                        $('.suggest').append('<a style="color:black;text-decoration:none;"'+
                        'href="'+ data[0].data[index].url_key+'">'+
                        '<div class="product">'+
                        '<div class="img">'+
                        '<img style="'+
                        'width:100%;'+
                        '" src="'+data[2][index][0].small_image_url+'" >'+
                        '</div>'+
                        '<div class="imgp">'+
                        '<p class="image_name">'+data[0].data[index].name+'</p>'+
                        '<p>'+data[1][index]+'</p>'+
                        '</div></div></a>');
                        }
                    }
                }       
    var search = event.target.value;
    var n = search.length;
    if(n >= 2){
        var str = document.getElementById("old-new").innerHTML;
        var search = document.querySelector('input[type="search"]').value;
        var regex = new RegExp(search, 'g');
        var result = str.replace(regex, '<b>' + search + '</b>');
        document.getElementById("old-new").innerHTML = result;
    }
        }else{
        $('.suggest').append('<div class="no_result">'+
                 '<p>{{ __('suggestion::app.no_results') }}</p>'+             
                '</div>');
                                        }
                                    }
                                }
                            });
                        }
</script>
<script>
    $(document).ready(function(){    
        $(document).mouseup(function(e){
            var container = $('input[type="search"]');
            var scroll_bar = $(".suggest");
                if(!scroll_bar.is(e.target) && !container.is(e.target) && container.has(e.target).length === 0){
                    $('.suggest').hide();
               }else{
                    $('.suggest').show();
                }
        });

        $('.search').on('keyup', () => {
            var search = document.querySelector('.search').value;
    var n = search.length;
    if(n >= 2){
setTimeout(time,400);
function time(){
var str = document.getElementById("old-ne").innerHTML;
var search = document.querySelector('.search').value;
var regex = new RegExp(search, 'g');
var result = str.replace(regex, '<b>' + search + '</b>');
document.getElementById("old-ne").innerHTML = result;
}
    }
        });
    });
</script>
@endpush