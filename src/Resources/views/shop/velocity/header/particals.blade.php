@push('scripts')
    <script type="text/x-template" id="cart-btn-template">
        <button
            type="button"
            id="mini-cart"
            @click="toggleMiniCart"
            :class="`btn btn-link disable-box-shadow ${itemCount == 0 ? 'cursor-not-allowed' : ''}`">

            <div class="mini-cart-content">
                <i class="material-icons-outlined text-down-3">shopping_cart</i>
                <span class="badge" v-text="itemCount" v-if="itemCount != 0"></span>
                <span class="fs18 fw6 cart-text">{{ __('velocity::app.minicart.cart') }}</span>
            </div>
            <div class="down-arrow-container">
                <span class="rango-arrow-down"></span>
            </div>
        </button>
    </script>

    <script type="text/x-template" id="close-btn-template">
        <button type="button" class="close disable-box-shadow">
            <span class="white-text fs20" @click="togglePopup">×</span>
        </button>
    </script>

    <script type="text/x-template" id="quantity-changer-template">
        <div :class="`quantity control-group ${errors.has(controlName) ? 'has-error' : ''}`">
            <label class="required" for="quantity-changer">{{ __('shop::app.products.quantity') }}</label>
            <button type="button" class="decrease" @click="decreaseQty()">-</button>

            <input
                :value="qty"
                class="control"
                :name="controlName"
                :v-validate="validations"
                id="quantity-changer"
                data-vv-as="&quot;{{ __('shop::app.products.quantity') }}&quot;"
                readonly />

            <button type="button" class="increase" @click="increaseQty()">+</button>

            <span class="control-error" v-if="errors.has(controlName)">@{{ errors.first(controlName) }}</span>
        </div>
    </script>
@endpush

@include('velocity::UI.header')

@push('scripts')
    <script type="text/x-template" id="logo-template">
        <a
            :class="`left ${addClass}`"
            href="{{ route('shop.home.index') }}"
            aria-label="Logo">

            @if ($logo = core()->getCurrentChannel()->logo_url)
                <img class="logo" src="{{ $logo }}" alt="" width="200" height="50" />
            @else
                <img class="logo" src="{{ asset('themes/velocity/assets/images/logo-text.png') }}" alt="" width="200" height="50" />
            @endif
        </a>
    </script>

    <script type="text/x-template" id="searchbar-template">
        <div class="right searchbar">
            <div class="row">
                <div class="col-lg-5 col-md-12">
                    <div class="input-group">
                        <form
                            method="GET"
                            role="search"
                            id="search-form"
                            action="{{ route('velocity.search.index') }}">
                        <div style="position:relative;">
                            <div
                                class="btn-toolbar full-width"
                                role="toolbar">

                                <div class="btn-group full-width force-center" >
                                    <div class="selectdiv">
                                        <select class="form-control fs13 styled-select" name="category" @change="focusInput($event)" aria-label="Category">
                                            <option value="">
                                                {{ __('velocity::app.header.all-categories') }}
                                            </option>

                                            <template v-for="(category, index) in $root.sharedRootCategories">
                                                <option
                                                    :key="index"
                                                    selected="selected"
                                                    :value="category.id"
                                                    v-if="(category.id == searchedQuery.category)">
                                                    @{{ category.name }}
                                                </option>

                                                <option :key="index" :value="category.id" v-else>
                                                    @{{ category.name }}
                                                </option>
                                            </template>
                                        </select>

                                        <div class="select-icon-container d-inline-block float-right">
                                            <span class="select-icon rango-arrow-down"></span>
                                        </div>
                                    </div>
                                    <input
                                        required
                                        id ="searchs"
                                        name="term"
                                        type="search"
                                        @keyup="someFunctionRun($event)"
                                        class="form-control"
                                        placeholder="{{ __('velocity::app.header.search-text') }}"
                                        aria-label="Search"
                                        v-model:value="inputVal" />

                                    <image-search-component></image-search-component>

                                    <button class="btn" type="button" id="header-search-icon" aria-label="Search" @click="submitForm">
                                        <i class="fs16 fw6 rango-search"></i>
                                    </button>
                                    </div>     
                                </div>
                            <div id="old-new" class="suggests full-width"> </div>
                            </div> 
                        </form>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 vc-full-screen">
                    <div class="left-wrapper">
                        @php
                            $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;

                            $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;
                        @endphp

                        {!! view_render_event('bagisto.shop.layout.header.wishlist.before') !!}
                            @if($showWishlist)
                                <a class="wishlist-btn unset" :href="`{{ route('customer.wishlist.index') }}`">
                                    <i class="material-icons">favorite_border</i>
                                    <div class="badge-container" v-if="wishlistCount > 0">
                                        <span class="badge" v-text="wishlistCount"></span>
                                    </div>
                                    <span>{{ __('shop::app.layouts.wishlist') }}</span>
                                </a>
                            @endif
                        {!! view_render_event('bagisto.shop.layout.header.wishlist.after') !!}

                        {!! view_render_event('bagisto.shop.layout.header.compare.before') !!}
                            @if ($showCompare)
                                <a
                                    class="compare-btn unset"
                                    @auth('customer')
                                        href="{{ route('velocity.customer.product.compare') }}"
                                    @endauth

                                    @guest('customer')
                                        href="{{ route('velocity.product.compare') }}"
                                    @endguest
                                    >

                                    <i class="material-icons">compare_arrows</i>
                                    <div class="badge-container" v-if="compareCount > 0">
                                        <span class="badge" v-text="compareCount"></span>
                                    </div>
                                    <span>{{ __('velocity::app.customer.compare.text') }}</span>
                                </a>
                            @endif
                        {!! view_render_event('bagisto.shop.layout.header.compare.after') !!}

                        {!! view_render_event('bagisto.shop.layout.header.cart-item.before') !!}
                            @include('shop::checkout.cart.mini-cart')
                        {!! view_render_event('bagisto.shop.layout.header.cart-item.after') !!}
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>
    <script type="text/x-template" id="image-search-component-template">
        <div class="d-inline-block image-search-container" v-if="image_search_status">
            <label for="image-search-container">
                <i class="icon camera-icon"></i>

                <input
                    type="file"
                    class="d-none"
                    ref="image_search_input"
                    id="image-search-container"
                    v-on:change="uploadImage()" />

                <img
                    class="d-none"
                    id="uploaded-image-url"
                    :src="uploadedImageUrl" alt="" width="20" height="20" />
            </label>
        </div>
    </script>

    <script>
    var url = window.location.toString();
    if(url.match(/%3Cb%3E/gi) == '%3Cb%3E'){
    var urla = url.replace('%3Cb%3E','');
    window.location = urla.replace('%3C/b%3E',''); 
    }

</script>

    <script type="text/javascript">
        (() => {
            Vue.component('cart-btn', {
                template: '#cart-btn-template',

                props: ['itemCount'],

                methods: {
                    toggleMiniCart: function () {
                        let modal = $('#cart-modal-content')[0];
                        if (modal)
                            modal.classList.toggle('hide');

                        let accountModal = $('.account-modal')[0];
                        if (accountModal)
                            accountModal.classList.add('hide');

                        event.stopPropagation();
                    }
                }
            });

            Vue.component('close-btn', {
                template: '#close-btn-template',

                methods: {
                    togglePopup: function () {
                        $('#cart-modal-content').hide();
                    }
                }
            });

            Vue.component('quantity-changer', {
                template: '#quantity-changer-template',
                inject: ['$validator'],
                props: {
                    controlName: {
                        type: String,
                        default: 'quantity'
                    },

                    quantity: {
                        type: [Number, String],
                        default: 1
                    },

                    minQuantity: {
                        type: [Number, String],
                        default: 1
                    },

                    validations: {
                        type: String,
                        default: 'required|numeric|min_value:1'
                    }
                },

                data: function() {
                    return {
                        qty: this.quantity
                    }
                },

                watch: {
                    quantity: function (val) {
                        this.qty = val;

                        this.$emit('onQtyUpdated', this.qty)
                    }
                },

                methods: {
                    decreaseQty: function() {
                        if (this.qty > this.minQuantity)
                            this.qty = parseInt(this.qty) - 1;

                        this.$emit('onQtyUpdated', this.qty)
                    },

                    increaseQty: function() {
                        this.qty = parseInt(this.qty) + 1;

                        this.$emit('onQtyUpdated', this.qty)
                    }
                }
            });

            Vue.component('logo-component', {
                template: '#logo-template',
                props: ['addClass'],
            });

            Vue.component('searchbar-component', {
                template: '#searchbar-template',

                data: function () {
                    return {
                        inputVal: '',
                        compareCount: 0,
                        wishlistCount: 0,
                        searchedQuery: [],
                        isCustomer: '{{ auth()->guard('customer')->user() ? "true" : "false" }}' == "true",
                    }
                },

                watch: {
                    '$root.headerItemsCount': function () {
                        this.updateHeaderItemsCount();
                    }
                },

                created: function () {
                    let searchedItem = window.location.search.replace("?", "");
                    searchedItem = searchedItem.split('&');

                    let updatedSearchedCollection = {};

                    searchedItem.forEach(item => {
                        let splitedItem = item.split('=');
                        updatedSearchedCollection[splitedItem[0]] = decodeURI(splitedItem[1]);
                    });

                    if (updatedSearchedCollection['image-search'] == 1) {
                        updatedSearchedCollection.term = '';
                    }

                    this.searchedQuery = updatedSearchedCollection;

                    if (this.searchedQuery.term) {
                        this.inputVal = decodeURIComponent(this.searchedQuery.term.split('+').join(' '));
                    }

                    this.updateHeaderItemsCount();
                },

                methods: {
                    'someFunctionRun': function(event) {
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
                     var display='<?php $hello= core()->getCurrentLocale()->code;
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
                    $('.suggests').html(''); 
    if(term.length !== 0){
        if(data[0].data.length !== 0){
            if(display_category == 1){
                if(data[0].data.length < no_of_terms){
                    for (let index = 0; index < data[0].data.length; index++) {
                        if(data[0].data[index].product.categories[0]){
                                if(data[0].data[index].product.categories[0].name == 'Root'){
                                    $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                            '<p>'+data[0].data[index].name+'</p>'+
                            '</div></a>');     
                                }else{
                                        $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                                            '<p>'+data[0].data[index].name+' {{ __('suggestion::app.in') }} '+data[0].data[index].product.categories[0].name+'</p>'+
                                            '</div></a>');
                                }
                            }else{
                                $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                            '<p>'+data[0].data[index].name+'</p>'+
                            '</div></a>');
                            }
                         }
                    }else if (data[0].data.length >= no_of_terms) {
                        for (let index = 0; index < no_of_terms; index++) {
                            if(data[0].data[index].product.categories[0]){
                                if(data[0].data[index].product.categories[0].name == 'Root'){
                                    $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                            '<p>'+data[0].data[index].name+'</p>'+
                            '</div></a>');     
                                }else{
                                        $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                                            '<p>'+data[0].data[index].name+' {{ __('suggestion::app.in') }} '+data[0].data[index].product.categories[0].name+'</p>'+
                                            '</div></a>');
                                }
                            }else{
                                $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                            'href="'+data[0].data[index].url_key+'"> <div class="velocity_category">'+
                            '<p>'+data[0].data[index].name+'</p>'+
                            '</div></a>');
                            }
                        }
                    }
                }
            if(display_terms_toggle == 1){         
                if(display == 'ar'){
                    $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                        'href="categorysearch?category=&term='+term+'"><div class="velocity_terms">'+
                        '<p class="velocity_termsa">'+term+'</p>'+
                        '<p class="ar_termsa">'+data[0].data.length+'</p>'+
                        '</div></a>');
                }else{
                    $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                        'href="categorysearch?category=&term='+term+'"><div class="velocity_terms">'+
                        '<p class="velocity_termsa">'+term+'</p>'+
                        '<p class="ar_termsb">'+data[0].data.length+'</p>'+
                        '</div></a>');
                    }
                }   
            if(display_product_toggle == 1){
                $('.suggests').append('<div class="velocity_popular">'+
                 '<p>{{ __('suggestion::app.popular_products') }}</p>'+
                    '</div>');
                if (data[0].data.length < no_of_products) {
                    for (let index = 0; index < data[0].data.length; index++) {  
                        if(data[0].data[index].product.type == 'bundle'){
                            var mini_price = parseInt(data[0].data[index].min_price);
                            var minimum = mini_price.toFixed(2);  
                            $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                'href="'+data[0].data[index].url_key+'">'+
                                '<div class="velocity_product">'+
                                '<div class="velocity_img">'+
                                '<img style="'+
                                'width:100%;'+
                                '" src="'+data[2][index][0].small_image_url+'" >'+
                                '</div>'+
                                '<div class="imgp">'+
                                '<p class="velocity_img_name">'+data[0].data[index].name+'<br>{{ __('suggestion::app.starting_from') }} $'+minimum+'</p>'+
                                '</div></div></a>');
                        }else{    
                        $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                'href="'+data[0].data[index].url_key+'">'+
                                '<div class="velocity_product">'+
                                '<div class="velocity_img">'+
                                '<img style="'+
                                'width:100%;'+
                                '" src="'+data[2][index][0].small_image_url+'" >'+
                                '</div>'+
                                '<div class="imgp">'+
                                '<p class="velocity_img_name">'+data[0].data[index].name+'<br>'+data[1][index]+'</p>'+
                                '</div></div></a>');
                        }
                            }
                        }else if(data[0].data.length >= no_of_products){
                            for (let index = 0; index < no_of_products; index++) {         
                                if(data[0].data[index].product.type == 'bundle'){
                            var mini_price = parseInt(data[0].data[index].min_price);
                            var minimum = mini_price.toFixed(2);  
                            $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                'href="'+data[0].data[index].url_key+'">'+
                                '<div class="velocity_product">'+
                                '<div class="velocity_img">'+
                                '<img style="'+
                                'width:100%;'+
                                '" src="'+data[2][index][0].small_image_url+'" >'+
                                '</div>'+
                                '<div class="imgp">'+
                                '<p class="velocity_img_name">'+data[0].data[index].name+'<br>{{ __('suggestion::app.starting_from') }} $'+minimum+'</p>'+
                                '</div></div></a>');
                        }else{    
                        $('.suggests').append('<a style="color:black;text-decoration:none;"'+
                                'href="'+data[0].data[index].url_key+'">'+
                                '<div class="velocity_product">'+
                                '<div class="velocity_img">'+
                                '<img style="'+
                                'width:100%;'+
                                '" src="'+data[2][index][0].small_image_url+'" >'+
                                '</div>'+
                                '<div class="imgp">'+
                                '<p class="velocity_img_name">'+data[0].data[index].name+'<br>'+data[1][index]+'</p>'+
                                '</div></div></a>');
                        }
                                    }
                                }
                            }
                                    var search = event.target.value;
                                        var n = search.length;
                                        if(n >= 2){
                                                var str = document.getElementById("old-new").innerHTML;
                                                var search = event.target.value;
                                                var regex = new RegExp(search, 'g');
                                                var result = str.replace(regex, '<b>' + search + '</b>');
                                                document.getElementById("old-new").innerHTML = result;
                                        }
                                }else{
                        $('.suggests').append('<div class="velocity_no_result">'+
                                                    '<p>{{ __('suggestion::app.no_results') }}</p>'+
                                            '</div>');   
                                    }                         
                                }
                            }
                        });  
                    },

                    'focusInput': function (event) {
                        $(event.target.parentElement.parentElement).find('input').focus();
                    },

                    'submitForm': function () {
                        if (this.inputVal !== '') {
                            $('input[name=term]').val(this.inputVal);
                            $('#search-form').submit();
                        }
                    },

                    'updateHeaderItemsCount': function () {
                        if (! this.isCustomer) {
                            let comparedItems = this.getStorageValue('compared_product');

                            if (comparedItems) {
                                this.compareCount = comparedItems.length;
                            }
                        } else {
                            this.$http.get(`${this.$root.baseUrl}/items-count`)
                                .then(response => {
                                    this.compareCount = response.data.compareProductsCount;
                                    this.wishlistCount = response.data.wishlistedProductsCount;
                                })
                                .catch(exception => {
                                    console.log(this.__('error.something_went_wrong'));
                                });
                        }
                    }
                }
            });

            Vue.component('image-search-component', {
                template: '#image-search-component-template',
                data: function() {
                    return {
                        uploadedImageUrl: '',
                        image_search_status: "{{core()->getConfigData('general.content.shop.image_search') == '1' ? 'true' : 'false'}}" == 'true'
                    }
                },

                methods: {
                    uploadImage: function() {
                        var imageInput = this.$refs.image_search_input;

                        if (imageInput.files && imageInput.files[0]) {
                            if (imageInput.files[0].type.includes('image/')) {
                                if (imageInput.files[0].size <= 2000000) {
                                    this.$root.showLoader();

                                    var formData = new FormData();

                                    formData.append('image', imageInput.files[0]);

                                    axios.post(
                                        "{{ route('shop.image.search.upload') }}",
                                        formData,
                                        {
                                            headers: {
                                                'Content-Type': 'multipart/form-data'
                                            }
                                        }
                                    ).then(response => {
                                        var net;
                                        var self = this;
                                        this.uploadedImageUrl = response.data;


                                        async function app() {
                                            var analysedResult = [];

                                            var queryString = '';

                                            net = await mobilenet.load();

                                            const imgElement = document.getElementById('uploaded-image-url');

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

                                                window.showAlert(
                                                    `alert-danger`,
                                                    this.__('shop.general.alert.error'),
                                                    "{{ __('shop::app.common.error') }}"
                                                );
                                            }

                                            localStorage.searchedImageUrl = self.uploadedImageUrl;

                                            queryString = localStorage.searched_terms = analysedResult.join('_');

                                            self.$root.hideLoader();

                                            window.location.href = "{{ route('shop.search.index') }}" + '?term=' + queryString + '&image-search=1';
                                        }

                                        app();
                                    }).catch(() => {
                                        this.$root.hideLoader();

                                        window.showAlert(
                                            `alert-danger`,
                                            this.__('shop.general.alert.error'),
                                            "{{ __('shop::app.common.error') }}"
                                        );
                                    });
                                } else {
                                        imageInput.value = '';

                                        window.showAlert(
                                            `alert-danger`,
                                            this.__('shop.general.alert.error'),
                                            "{{ __('shop::app.common.image-upload-limit') }}"
                                        );
                                }
                            } else {
                                imageInput.value = '';

                                alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                            }
                        }
                    }
                }
            });
        })()
    </script>
@endpush