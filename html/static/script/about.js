require([
    'vue',
    'footerComponent',
    'swiper',
    'jquery',
    'jqueryCookie',
    'jqueryWeui'
], function (Vue,footerComponent,Swiper) {
    new Vue({
        el:'#app',
        data:{
            about_message_data:"",
        },
        mounted: function () {
            this.banner();

        },
        methods: {
            banner: function () {
                var _this = this;
                $.ajax({
                    url: "/Home/category/ajax_getDetail",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id:1,
                    },
                    timeout: 10000,
                    async: false,
                    success: function (data) {
                        _this.about_message_data = data;
                    }
                })
            }
        }
    })
});