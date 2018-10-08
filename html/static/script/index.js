require([
    'vue',
    'swiper',
    'jquery',
    'footerComponent',
    'jqueryWeui',
    'jqueryCookie'

], function (Vue, Swiper, $,footerComponent) {
    new Vue({
        el: '#app',
        data: {
            bannerData:[],
            data_box:"",
        },
        mounted: function(){
            this.indexData();
            this.banner();



        },
        methods: {
            banner:function(){
                var _this = this;
                $.ajax({
                    url:"/Home/slider/ajax_getBanner",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        type:0,
                        limit:5
                    },
                    timeout: 10000,
                    async: false,
                    success:function(data){
                        _this.bannerData = data;
                        _this.$nextTick(function () {
                            new Swiper('.box_header_banner', {
                                autoplay: true,
                                slidesPerView: 'auto',
                                pagination: {
                                    el: '.swiper-pagination'
                                }
                            })
                        })
                    }
                })
            },
            shopDetail_link:function(m){
                window.location.href = '/index.php?s=/home/index/shop_detail.html&id=' +m;
            },
            indexData:function(){
                var _this = this;
                $.ajax({
                    url: "/Home/index/index",
                    type: 'post',
                    dataType: 'json',
                    data: {
                    },
                    timeout: 10000,
                    async: false,
                    success: function (data) {
                        _this.data_box = data;
                        _this.$nextTick(function () {
                            new Swiper('.integral_container', {
                                freeMode: true,
                                slidesPerView: 'auto'
                            });
                            new Swiper('.box_shop_banner', {
                                freeMode: true,
                                slidesPerView: 'auto'
                            })
                        })
                    }
                })
            }

        }
    })
});