
require([
    'vue',
    'swiper',
    'jquery',
    'footerComponent',
    'jqueryWeui',
    'jqueryCookie'

], function (Vue, Swiper, $, footerComponent) {

    new Vue({
        el: '#app',
        data: {
            menu_sidebar:1,
            stores:[],
            stores_detail:"",
            video_data:[],
        },
        mounted: function () {
            this.shop();
        },
        methods: {
            sidebar_link:function(m){
                window.location.href = '/index.php?s=/home/index/shop_detail.html&id=' + m;
            },
            shop:function(){
                var _this = this;
                $.ajax({
                    url:'/Home/restaurant/ajax_getRestaurantList',
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        _this.stores = data;
                        _this.stores_detail = data[0];
                        _this.$nextTick(function () {
                            new Swiper('#banner', {
                                pagination: {
                                    el: '.swiper-pagination',
                                    type: 'fraction'
                                }
                            })
                        })
                    }
                })
            },
        }
    })
});
