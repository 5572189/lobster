require([
    'vue',
    'jquery',
    'footerComponent',
    'swiper'
], function (Vue,$,footerComponent,Swiper) {
    new Vue({
        el:'#app',
        data:{
            shop_detail_data:"",
        },
        mounted: function () {
            this.shop_detail();
        },
        methods: {
            getUrlParms: function (name) {
                var parmsStr = window.location.search;
                var parmsArr = parmsStr.split('&')
                var parms = {}
                for (var i = 0; i < parmsArr.length; i++) {
                    parms[parmsArr[i].split('=')[0]] = parmsArr[i].split('=')[1]
                }
                return parms[name]
            },
            shop_detail:function(){
                var _this = this;
                $.ajax({
                    url: '/Home/restaurant/ajax_getRestaurantList',
                    type: 'post',
                    dataType: 'json',
                    data:{
                        id: _this.getUrlParms('id')
                    },
                    success: function (data) {
                        console.log(data)
                        _this.shop_detail_data = data[0];
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